<?php

namespace Aria;

class ConfigMgr
{
    private $_config = array();
    private static $_instance;

    public static function getInstance() {
        if (!empty(self::$_instance)) {
            return self::$_instance;
        }

        return self::$_instance = new ConfigMgr();
    }

    public function loadFromJson($path) {

    }

    public function loadFromYaml($path) {

    }
}
