<?php


class Database
{
    private $dsn;
    private $config;
    private $pdo;

    public function __construct()
    {
        $this->config = include './config.php';
        $this->dsn = 'mysql:host=' . $this->config['host'] . ';dbname='
            . $this->config['dbname'] . ';charset=UTF8';

    }

    public function connect(): bool
    {
        try {
            $this->pdo = new PDO($this->dsn, $this->config['user'],
                $this->config['password']);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


}

