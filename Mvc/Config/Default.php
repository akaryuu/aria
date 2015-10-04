<?php

namespace Aria;

class Mvc_Config_Default
{
    public static function get() {
        return array(
            'root_path' => './', // root path of application
            'libs_path' => './libs', //additional vendor libraries
            'aria_path' => './Aria', // Aria library path
            'script_path' => '/' // application path relative to domain url eg. /cms  
        );
    }
}
