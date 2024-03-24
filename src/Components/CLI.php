<?php

namespace App\Components;

class CLI
{
    public static function write($message): void
    {
        echo $message;
    }

    public static function writeLine($message): void
    {
        echo self::write($message) . PHP_EOL;
    }
}