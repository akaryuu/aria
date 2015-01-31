<?php

namespace Aria;

class Db_Schema
{
    public function update() {
        //echo 'Updating database schema';
        $parser = new Db_Schema_Parser();
        if (file_exists(CONFIG_PATH . '/db') && is_dir(CONFIG_PATH . '/db')) { 
            //var_dump(scandir(CONFIG_PATH . '/db')); die;
        } else {
            throw new Exception('Schema directory is missing in configuration path: ' . CONFIG_PATH . '/db');
        }
        $sql = new Db_Sql();
        $sql->delete()->from(array('users'))->execute();
        echo $sql->getString();
    }
}
