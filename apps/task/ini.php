<?php

try {
    (new \vendor\Env('../.env'))->load();
} catch (Exception $e) {
    print '[' . date('Y-m-d H:i:s') . ']' . $e->getMessage() . ' TRACE: ' . $e->getTraceAsString() . PHP_EOL;
    exit();
}




