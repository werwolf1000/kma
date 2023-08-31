<?php

namespace vendor;

use Exception;

class Model
{
    /** @var int идентификтаор записи  */
    public int $id;

    /**
     * Поля исключаемые из вставки
     * @var array
     */
    public static array $excluded_fields = [
        'id' => 'id'
    ];

    /** @var string имя таблицы в БД */
    protected static string $table = '';

    /**
     * Производит сохранение в БД
     * @throws Exception
     */
    public function save(): void
    {
        $this->insert();
    }

    /**
     * Добавляет записи в БД
     * @throws Exception
     */
    public function insert(): void
    {

        $fields = [];
        $placeHolders = [];

        foreach ($this as $prop => $value) {
            if (!isset(static::$excluded_fields[$prop])) {
                $fields[] = $prop . '=:' . $prop;
                $placeHolders[':' . $prop] = $value;
            }
        }
        $sql = 'INSERT INTO ' . static::$table . ' SET ' . implode(',', $fields) . ' ON DUPLICATE '
            . ' KEY UPDATE ' . implode(',', $fields);
        $db = Db::getInstance();
        $db->execute($sql, $placeHolders);
    }

    /**
     * @throws Exception
     */
    public function findAll(): array
    {
        $db = Db::getInstance();
        $sql = 'SELECT * FROM ' . static::$table;
        return $db->query($sql, static::class);
    }
}
