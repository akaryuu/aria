<?php

namespace Aria;

class Debug
{
    public static function dump($var)
    {
        ob_start();
        print_r($var);
        $dump = ob_get_clean();
        echo '<pre>' . $dump . '</pre>';
    }

    public static function log($msg)
    {
        echo '<pre>' . $msg . '</pre>';        
    }
}
