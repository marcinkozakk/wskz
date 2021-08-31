<?php

class Random
{
    public static function generate(): array
    {
        $seed = self::makeSeed();

        return self::retrieve($seed);
    }

    private static function makeSeed(): int
    {
        list($usec, $sec) = explode(' ', microtime());
        return $sec + $usec * 1000000;
    }

    public static function retrieve($id): array
    {
        srand($id);

        return [
            'id'     => $id,
            'number' => rand(0, 1000)
        ];
    }
}