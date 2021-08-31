<?php

class Mail
{
    private array $config;

    public function __construct()
    {
        $this->config = require 'config.php';
    }

    public function sendReminder($email, $userId, $secret)
    {
        mail(
            $email,
            'Przypomnienie hasla',
            "Aby ustawić nowe hasło wejdź pod poniższy link: \n\n" . $this->config['url']
            . 'auth/reset.php?id=' . $userId . '&s='
            . $secret,
            'From: webmaster@example.com'
        );
    }

    public function sendWelcome($email, $name)
    {
        mail(
            $email,
            'Witaj na naszej stronie!',
            "Cześć $name!\n\nMiło, że założyłeś konto na naszej stronie. \n\nPozdrawiam, Administrator",
            'From: webmaster@example.com'
        );
    }
}