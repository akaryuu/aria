<?php

namespace Aria;

class Mvc_Model
{
    public function __get($field)
    {
        return $this->$field;
    }

    public function __set($field, $value)
    {
        $this->$field = $value;
    }

    public function __call($name, $arguments) {
        die('called');
    }
}
