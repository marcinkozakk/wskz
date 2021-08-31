<?php

class Console
{
    public static function main()
    {
        echo("\n==== Hello ====\n");
        echo("How to use?: \ntype '<dog name> <command>'\n\n");
        echo("Avaliable dogs: Dachshund, Foxterrier, PlushPug, Pug, Shepherd, SqueakerPoodle\n");
        echo("Avaliable commands: sound, hunt\n");

        while (true) {
            $command = readline("\n-> ");
            try {
                self::command($command);
            } catch (Throwable $e) {
                echo 'Whoops, wrong command';
            }
        }
    }

    public static function command($command)
    {
        list($dog, $command) = explode(' ', $command);
        echo (new $dog)->{$command}();
    }

}