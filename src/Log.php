<?php

namespace src;

class Log
{
    public static function msg(string $message, mixed $data = null)
    {
        $log = '[' . date('Y-m-d H:i:s') . ']: ' . $message . PHP_EOL;
        if($data){
            $log.= $data;
        }
        file_put_contents(ROOT . '/tmp/log.txt', $log . PHP_EOL, FILE_APPEND);
    }
}