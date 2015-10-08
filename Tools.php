<?php

namespace Aria;

class Tools
{
    public static function dump($variable)
    {
        ob_start();
        print_r($variable);
        $dump =  ob_get_clean();
        echo '<pre>' . $dump . '</pre>';
    }

    public static function debug($value, $desc='NoName')
    {
        self::dump($value);
        //$session = Mvc_FrontController::getInstance()->getRequest()->getSession();
        //$debugobj = $session['phpdebugobj'];
        //if ($desc == 'query')
        //{
        //    $debugobj->query($value);
        //}
        //else
        //{
        //    $debugobj->dump($value, $desc);
        //}
    }
}
