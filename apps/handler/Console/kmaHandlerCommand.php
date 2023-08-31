<?php
require_once dirname(__DIR__).'/autoload.php';


try {
    (new \vendor\Env(dirname(__DIR__).'/.env'))->load();
    $rmq = new \vendor\RabbitMQ();
    $rmq->listen($_ENV['AMQP_QUEUE'], new \queue\KmaTaskHandler());

} catch (\Exception $e) {
    print '[' . date('Y-m-d H:i:s') . ']' . $e->getMessage() . ' TRACE: ' . $e->getTraceAsString() . PHP_EOL;
}
