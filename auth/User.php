<?php

require './Database.php';

class User
{
    public bool $valid = true;
    public array $errors;
    private array $dbParams;

    public function __construct(array $post = [])
    {
        if (!empty($post) && $this->validate($post)) {
            $this->valid = false;
        }
    }

    private function validate(array $post): bool
    {
        if (strlen($post['login']) < 6) {
            $this->errors[] = 'LOGIN_LEN';
        } elseif (!ctype_alnum($post['login'])) {
            $this->errors[] = 'LOGIN_ALNUM';
        } else {
            $this->dbParams[':login'] = $post['login'];
        }

        if (strlen($post['password']) < 8) {
            $this->errors[] = 'PASS_LEN';
        } else {
            $this->dbParams[':password'] = password_hash($post['password'],
                PASSWORD_DEFAULT);
        }

        if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'EMAIL_INVALID';
        } else {
            $this->dbParams[':email'] = $post['email'];
        }

        if (empty($post['first_name']) || empty($post['last_name'])) {
            $this->errors[] = 'NAMES_EMPTY';
        } else {
            $this->dbParams[':first_name'] = $post['first_name'];
            $this->dbParams[':last_name'] = $post['last_name'];
        }

        if ($post['sex'] !== 'male' && $post['sex'] !== 'female') {
            $this->errors[] = 'SEX_INVALID';
        } else {
            $this->dbParams[':sex'] = $post['sex'];
        }

        return !empty($this->errors);
    }

    public function login($login, $password)
    {
        $db = new Database();
        $db->connect();

        $user = $db->login($login, $password);
        if ($user !== false) {
            session_regenerate_id();
            $_SESSION['userId'] = $user['id'];
            $_SESSION['userName'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['sex'] = $user['sex'];

            return true;
        }
        return false;
    }

    public function save()
    {
        $db = new Database();
        $db->connect();

        return $db->createUser($this->dbParams);
    }
}