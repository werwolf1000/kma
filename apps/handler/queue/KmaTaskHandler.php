<?php

namespace queue;

use Exception;
use services\KmaParser;
use vendor\IRabbitMQHandler;

class KmaTaskHandler implements IRabbitMQHandler
{
    /**
     * @throws Exception
     */
    public function handler(string $message): true
    {
        (new KmaParser())->run($message);
        return true;
    }
}