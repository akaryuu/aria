<?php

namespace Aria;

class Mvc_Model extends Model
{
    protected $_db;

    function __construct()
    {
        $this->_db = Registry::getInstance()->get('database');
    }
}
