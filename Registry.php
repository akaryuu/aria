<?php

namespace Aria;

class Registry
{
    private static $_instance;

    private $_registry = array();

    public static function getInstance()
    {
        if (!(self::$_instance instanceof Registry))
        {
            self::$_instance = new Registry();
        }
        return self::$_instance;
    } 

    public function set($identifier, $value)
    {
        $this->_registry[$identifier] = $value;
    }

    public function get($identifier)
    {
        return $this->_registry[$identifier];
    }
}
