<?php

namespace services;

use Exception;
use models\KmaContentModel;

class KmaParser
{
    /**
     * Получает страницу (html код)
     * @param  string  $url
     * @param  string  $method
     * @param $params
     * @return string
     * @throws Exception
     */
    private function require(string $url, string $method = 'get', $params = []): string
    {
        $params = http_build_query($params);
        if ($ch = curl_init($url . '?' . $params)) {

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);

            if ($method == 'post') {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            }

            $res = curl_exec($ch);
            curl_close($ch);
            return $res;
        } else {
            throw new Exception('CURL ERROR . IMPOSSIBLE TO CONNECT TO' . $url);
        }

    }

    /**
     * Сохраняем полученные данные
     * @throws Exception
     */
    private function save(string $url, int $length): void
    {
        $model = new KmaContentModel();
        $model->setUrls($url);
        $model->setLength($length);
        $model->save();
    }

    /**
     * @throws Exception
     */
    public function run(string $url): void
    {
        try {
            $content = $this->require($url);
            $this->save($url, strlen($content));
        } catch (Exception $e) {
            print '[' . date('Y-m-d H:i:s') . ']' . $e->getMessage() . ' TRACE: ' . $e->getTraceAsString() . PHP_EOL;
        }

    }
}