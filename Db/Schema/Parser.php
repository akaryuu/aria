<?php

namespace Aria;

class Db_Schema_Parser
{
    private $tables = array();

    public function parse($file) {
        $object = json_decode(filegetcontents($file));
        var_dump($object);
    }
}
