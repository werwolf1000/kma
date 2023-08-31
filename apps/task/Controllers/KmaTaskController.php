<?php

namespace Controllers;

use Exception;
use models\KmaTaskModel;
use vendor\RabbitMQ;

class KmaTaskController
{
    /**
     * @throws Exception
     */
    public function taskToRabbit(): void
    {
        $urls = $this->getUrls();
        $rmq = new RabbitMQ();
        foreach ($urls as $key => $item) {
            echo "{$key} => {$item->urls}".PHP_EOL;
            $rmq->execute($item->urls, 'task');
            sleep(15);
        }
        $rmq->close();
        print PHP_EOL."__________отправка завершена__________".PHP_EOL;
    }

    /**
     * @throws Exception
     */
    public function getUrls(): array
    {
        $model = new KmaTaskModel();
        return $model->findAll();
    }
}