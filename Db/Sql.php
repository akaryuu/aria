<?php

namespace Aria;

class Db_Sql
{
    protected $_query = array(
        'action' => '',
        'columns' => array(),
        'tables' => array(),
        'values' => array(),
        'where' => array(),
        'limit' => 0,
        'offset' => 0
    );

    protected $_db;

    protected $_string = '';

    function __construct()
    {
        $this->_db = new Db();
    }

    public function select()
    {
        $this->_query['action'] = 'select';
        return $this;       
    }

    public function insert()
    {
        $this->_query['action'] = 'insert';
        return $this;       
    }

    public function columns(array $columns)
    {
        $this->_query['columns'] = $columns;
        return $this;
    }

    public function from(array $tables)
    {
        $this->_query['tables'] = $tables;
        return $this;
    }

    public function into(array $tables)
    {
        $this->_query['tables'] = $tables;
        return $this;
    }

    public function values(array $values)
    {
        $this->_query['values'] = $values;
        return $this;
    }

    public function where(array $where)
    {
        $this->_query['where'] = $where;
        return $this;
    }

    public function limit($limit, $offset = 0)
    {
        $this->_query['limit'] = $limit;
        $this->_query['offset'] = $offset;
        return $this;
    }

    public function execute()
    {
        $query = $this->_buildQuery();
        return $this->_string;
    }

    protected function _buildQuery()
    {
        $action = $this->_query['action'];

        if (empty($this->_query['action']))
        {
            throw new Exception('No operation set for this query. Use select, insert, update or delete');
        }

        $sql = '';

        switch ($action)
        {
            case 'select':
            {
                $sql[] = 'SELECT';
                $sql[] = $this->_prepareColumns();
                $sql[] = 'FROM';
                $sql[] = $this->_prepareTables();
                $sql[] = $this->_prepareConditions();
                $sql[] = $this->_prepareLimit();
                break;
            }
            case 'insert':
            {
                $sql[] = 'INSERT INTO';
                $sql[] = $this->_prepareTables();
                $sql[] = '(';
                $sql[] = $this->_prepareColumns();
                $sql[] = ')';
                $sql[] = 'VALUES (';
                $sql[] = $this->_prepareValues();
                $sql[] = ')';
                break;
            }
        }

        $this->_string = implode(' ', $sql);
        return $this->_string;

    }

    protected function _prepareTables()
    {
        if (empty($this->_query['tables']))
        {
            throw new Exception('No table set for this query');
        }

        $sql = array();

        foreach ($this->_query['tables'] as $alias => $table)
        {
            $sql[] = $table . (is_int($alias) ? '' : ' ' . $alias); 
        }

        return implode(',', $sql);
        
    }

    protected function _prepareColumns()
    {
        if (empty($this->_query['columns']))
        {
            if (!empty($this->_query['action']) && ($this->_query['action'] == 'select'))
            {
                $this->_query['columns'] = array('*');
            }
            else
            {
                throw new Exception('No columns set for this query. Use columns');
            }
        }

        $sql = array();

        foreach ($this->_query['columns'] as $alias => $column)
        {
            $sql[] = $column . (is_int($alias) ? '' : ' as ' . $alias); 
        }

        return implode(',', $sql);

    }

    protected function _prepareValues()
    {
        if (empty($this->_query['values']))
        {
            throw new Exception('No values set for this query');
        }

        $sql = array();

        foreach ($this->_query['values'] as $value)
        {
            $sql[] = '\'' . $value . '\''; 
        }

        return implode(',', $sql);

    }

    protected function _prepareConditions()
    {
        if (!empty($this->_query['where']))
        {
            $sql = array();

            foreach ($this->_query['where'] as $key => $value)
            {
                $sql[] = $key . '=' . '\'' . $value . '\''; 

            }

            return ' WHERE ' . implode(' ', $sql);
        }

        return '';

    }
    
    protected function _prepareLimit()
    {
        $sql = '';

        if ($this->_query['limit'] != 0) {
            $sql .= 'LIMIT ' . $this->_query['limit'];

            if ($this->_query['offset'] != 0) {
                $sql .= ' OFFSET ' . $this->_query['offset'];
            }
        }

        return $sql;
    }

    public function getString()
    {
        return $this->_string;
    }

}
