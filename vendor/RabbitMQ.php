<?php

namespace vendor;

use AMQPChannel;
use AMQPChannelException;
use AMQPConnection;
use AMQPConnectionException;
use AMQPExchange;
use AMQPExchangeException;
use AMQPQueue;
use Exception;

class RabbitMQ
{
    private AMQPConnection $connection;

    /**
     * Создаёт совединение с RabbitAMQP
     * @throws AMQPConnectionException
     * @throws Exception
     */
    public function __construct() {
        try {

            $this->connection = new AMQPConnection();
            $this->connection->setHost('rabbitmq');
            $this->connection->setLogin('admin');
            $this->connection->setPort(5672);
            $this->connection->setPassword('1234');
            $this->connection->connect();

            if (!$this->connection->isConnected()) {
                throw new Exception("Cannot connect to the broker! It might not be running");
            }

            return $this;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    /**
     * @throws AMQPExchangeException
     * @throws AMQPChannelException
     * @throws AMQPConnectionException
     */
    private function exchange(AMQPChannel $channel, string $name): AMQPExchange {
        $exchange = new AMQPExchange($channel);
        $exchange->setName('ex_name'.$name);
        $exchange->setType(AMQP_EX_TYPE_FANOUT);
        $exchange->declareExchange();
        return $exchange;
    }

    /**
     * Отправляет сообщение в очередь
     * @param  string  $message
     * @param  string  $name
     * @return void
     * @throws AMQPConnectionException
     * @throws Exception
     */
    public function execute(string $message, string $name): self
    {


        $channel = new AMQPChannel($this->connection);
        $exchange = $this->exchange($channel, $name);

        $queue = new AMQPQueue($channel);
        $queue->setName($name);
        $queue->declareQueue();
        $queue->bind($exchange->getName(), '');

        $exchange->publish($message, '');

        return $this;
    }

    public function close(): void
    {
        $this->connection->disconnect();
    }

    /**
     * Слушатели входящих сообщений
     * @param  string  $name
     * @param  IRabbitMQHandler  $class
     * @throws Exception
     */
    public function listen(string $name, IRabbitMQHandler $class): void
    {
        $channel = new AMQPChannel($this->connection);
        $exchange = $this->exchange($channel, $name);

        $queue = new AMQPQueue($channel);
        $queue->setName($name);
        $queue->declareQueue();
        $queue->bind($exchange->getName(), '');

        while (true) {
            if ($envelope = $queue->get()) {
                $message = $envelope->getBody();
                echo "delivery tag: ".$envelope->getDeliveryTag().PHP_EOL;

                if ($class->handler($message)) {
                    $queue->ack($envelope->getDeliveryTag());
                } else {
                    $queue->nack($envelope->getDeliveryTag(), AMQP_REQUEUE);
                }
            }
        }
    }
}