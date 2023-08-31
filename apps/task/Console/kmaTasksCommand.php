<?php
require_once dirname(__DIR__).'/autoload.php';


try {
    (new \vendor\Env(dirname(__DIR__).'/.env'))->load();
    $controller = new \Controllers\KmaTaskController();
    $controller->taskToRabbit();
} catch (\Exception $e) {
    print '[' . date('Y-m-d H:i:s') . ']' . $e->getMessage() . ' TRACE: ' . $e->getTraceAsString() . PHP_EOL;
}
