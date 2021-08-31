<?php


class Database
{
    private string $dsn;
    private array $config;
    private PDO $pdo;

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
            exit('mysql connection failed');
        }
    }

    public function createUser($data)
    {
        $sql
            = 'INSERT INTO users(' .
            'login, password, email, first_name, last_name, sex' .
            ') VALUES (' .
            ':login, :password, :email, :first_name, :last_name, :sex)';

        $statement = $this->pdo->prepare($sql);
        try {
            return $statement->execute($data);
        } catch (PDOException $e) {
            return $statement->errorInfo()[1];
        }
    }

    public function login($login, $password)
    {
        $sql = "select * from users where login = :login ";
        $statement = $this->pdo->prepare($sql);

        try {
            $statement->execute([
                ':login' => $login
            ]);
            $userData = $statement->fetch(PDO::FETCH_ASSOC);
            if ($userData && password_verify($password, $userData['password'])) {
                return $userData;
            }
        } catch (PDOException $e) {
            return false;
        }
        return false;
    }

}

