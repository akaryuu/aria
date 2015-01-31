<?php

namespace Aria;

class Mvc_ActiveRecord extends Mvc_Model
{
    private $_sql;

    function __construct() {
        parent::__construct();
        $this->_sql = new Db_Sql();
    }

    function __call($name, $arguments) {
        preg_match('/(set|get)([A-Z]\w+)/', $name, $matches);
        $property = lcfirst($matches[2]);
        if (property_exists(get_class($this), $property)) {
            if ($matches[1] == 'set') {
                $this->$property = $arguments[0];
            } else {
                return $this->$property;
            }
        } else {
            $class = get_class($this);
            $trace = debug_backtrace();
            $file = $trace[0]['file'];
            $line = $trace[0]['line'];
            trigger_error("Call to undefined method $class::$name() in $file on line $line", E_USER_ERROR);
        }

    }

    function find($id = null) {
        if (!empty($id)) {
            $result = $this->_sql->select()->from(array($this->table))->where(array('id' => $id))->execute();
            $result = $this->_db->query($result);
            Tools::dump($result);            
        }
    }
}
