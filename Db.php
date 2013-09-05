<?php

namespace Aria;

class Db
{
    /**
     * _connection 
     * 
     * @var PDO
     * @access protected
     */
    protected $_connection;

    protected $_config = array();

    function __construct($dsn = array())
    {
        if (!empty($dsn)) {
            if (!empty($dsn['db_type'])
                && !empty($dsn['db_host'])
                && !empty($dsn['db_name'])
                && !empty($dsn['db_user'])
                && !empty($dsn['db_pass'])
            ) {
                $this->_config = $dsn;
            } else {
                die('Some of the database parameters (db_type, db_host, db_name, dn_user, db_pass) are not specified'); 
            }
        }
    }

    /**
     * _getConnection 
     * 
     * @access protected
     * @return PDO
     */
    protected function _getConnection()
    {
        if (!empty($this->_config['db_type']) && $this->_config['db_type'] == 'mysql') {
            if (!$this->_connection)
            {
                try {
                    $this->_connection = new \PDO('mysql:'
                        . 'host=' . $this->_config['db_host']
                        . ';dbname=' . $this->_config['db_name']
                        , $this->_config['db_user']
                        , $this->_config['db_pass']
                    );
                } catch (\Exception $e) {
                    echo $e;     
                    die('database connection error');
                }
            }
            return $this->_connection;
        } else if (!empty($this->_config['db_type'])) {
            die('database type ' . $this->_config['db_type'] . ' is not yet supported');
        } else {
            die('database type must be specified');
        }

    }

    /**
     * Simplified method for querying records in database
     * TODO: Error handling
     */
    public  function query($query)
    {
        if ($query = $this->_getConnection()->query($query))
        {
            return $query->fetchAll();
        }
        else
        {
            echo 'SQL Query error';
            Tools::dump($this->_connection->errorInfo());
        }

    }
}
