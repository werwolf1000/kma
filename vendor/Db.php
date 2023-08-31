<?php

namespace vendor;


use Exception;
use PDO;

class Db
{
    private Pdo $dbh;
    private static ?Db $instance = null;

    /**
     * @return self
     */
    public static function getInstance(): ?Db
    {
        if (static::$instance === null) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * Выполняется соединение с БД
     * @throws Exception
     */
    protected function __construct()
    {

        $dsn = "mysql:dbname={$_ENV['MYSQL_NAME']};host={$_ENV['MYSQL_HOST']};port={$_ENV['MYSQL_PORT']};";
        // make a database connection
        $this->dbh = new PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $this->execute('SET NAMES UTF8;');
    }

    /**
     * Используется для запросов типа select
     * @param $sql
     * @param $class
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function query($sql, $class, $params = []) :array
    {
        $stmt = $this->dbh->prepare($sql);
        $res = $stmt->execute($params);
        if ($res === false) {
            throw new Exception('DB ERROR IN QUERY METHOD OF CLASS DB');
        }
        return $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    /**
     * @throws Exception
     */
    public function execute($sql, $params = []): true
    {
        $stmt = $this->dbh->prepare($sql);
        $res = $stmt->execute($params);
        if ($res === false) {
            throw new Exception('DB ERROR IN ' . __METHOD__ . ' METHOD OF CLASS DB');
        }
        return true;
    }
}
