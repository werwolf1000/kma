<?php

namespace vendor;

use Exception;

class Env
{
    /**
     * @throws Exception
     */
    public function __construct(private readonly string $filePath = './.env') {}

    /**
     * @param  string  $contents
     * @return void
     */
    public function parse(string $contents): void {

        preg_match_all('/^=(.*)$/', $contents, $matches);
        $lines = explode("\n", $contents);

        // Фильтруем массив строк
        $filtered_lines = array_filter($lines, function($line){
            return $line !== '';
        });

        // Преобразуем массив строк в массив переменных окружения
        foreach ($filtered_lines as $line) {
            list($key, $value) = explode('=', $line);
            $_ENV[$key] = $value;
        }
    }

    /**
     * @throws Exception
     */
    public function load(): void {
        if(!file_exists($this->filePath)) {
            throw new Exception('Не указан путь к файлу с переменными средами');
        }

        if((!is_readable($this->filePath) || ($contents = file_get_contents($this->filePath)) === false)) {
            throw new Exception('Не удалось прочитать файл с переменными средами');
        }
        $this->parse($contents);
    }
}