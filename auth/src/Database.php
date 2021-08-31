<?php

class Database
{
    private string $dsn;
    private array $config;
    private PDO $pdo;

    public function __construct()
    {
        $this->config = require 'config.php';
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
        $sql = 'SELECT * FROM users WHERE login = :login ';
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

    public function getUserByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email ';
        $statement = $this->pdo->prepare($sql);

        try {
            $statement->execute([
                ':email' => $email
            ]);
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }

    }

    public function createReminder($id, $secret)
    {
        $this->deleteOldReminder($id);

        $sql = 'INSERT INTO reminders(user_id, secret) VALUES ' .
            '(:user_id, :secret)';
        $statement = $this->pdo->prepare($sql);

        try {
            return $statement->execute([
                ':user_id' => $id,
                ':secret'  => $secret
            ]);
        } catch (PDOException $e) {
            return $statement->errorInfo()[1];
        }
    }

    private function deleteOldReminder($id)
    {
        $sql = 'DELETE FROM reminders WHERE user_id = :user_id';

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':user_id', $id, PDO::PARAM_INT);

        $statement->execute();
    }

    public function checkAndSetNewPassword($id, $secret, $newPassword): bool
    {
        if ($this->checkReminder($id, $secret)) {
            $sql = 'UPDATE users SET password = :password WHERE id = :id';
            $statement = $this->pdo->prepare($sql);

            try {
                return $statement->execute([
                    ':password' => password_hash($newPassword, PASSWORD_DEFAULT),
                    ':id'       => $id
                ]);
            } catch (PDOException $e) {
                return false;
            }
        }
        return false;
    }

    private function checkReminder($id, $secret): bool
    {
        $sql = 'SELECT id FROM reminders WHERE user_id = :user_id AND secret = :secret';
        $statement = $this->pdo->prepare($sql);

        try {
            $statement->execute([
                ':user_id' => $id,
                ':secret'  => $secret
            ]);

            return !empty($statement->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            return false;
        }
    }
}

