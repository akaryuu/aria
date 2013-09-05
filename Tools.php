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
        //$session = My_Controller_Front::getInstance()->getRequest()->getSession();
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
