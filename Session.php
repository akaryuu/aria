<?php

namespace Aria;

/**
 * Session 
 * 
 * @package 
 * @version 0.1
 * @copyright 2012 Marcin STaszewski
 * @author Marcin Staszewski <marcin@mouseinabox.info> 
 */
class Session
{
    protected static $_instance;

    protected function __construct()
    {
        session_start();
    }

    public static function getInstance()
    {
        if (!self::$_instance instanceOf Session)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function get($key)
    {
        if (isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        else
        {
            return false;
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}
