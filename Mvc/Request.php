<?php

namespace Aria;

/**
 * Mvc_Request
 * 
 * @package Mvc_Request
 * @version 0.1
 * @copyright 2012 Marcin Staszewski
 * @author Marcin Staszewski <marcin@mouseinabox.info> 
 */
class Mvc_Request extends Request
{

    protected $_router;

    public function __construct() {

        parent::__construct();

        $this->_router = new Router();
        $result = $this->_router->findRoute(ltrim($this->_uri, '/'));
        if ($result['success']) {
            if (!empty($result['redirect'])) {
                header('Location: ' . $result['redirect'][key($result['redirect'])], key($result['redirect']));
                die;
            }

            $this->_controllerName = strtolower($result['controller']);
            $this->_actionName = strtolower($result['action']);
            $this->_requestParams['_path'] = $result['params'];

        } else {

            $pieces = explode('?', $this->_uri);
            $path = isset($pieces[0]) ? $pieces[0] : null;
            $query = isset($pieces[1]) ? $pieces[1] : null;
            $pieces = explode(',', $path);

            if (isset($pieces[0]) && !empty($pieces[0]))
            {
                if ($pieces[0] == '/')
                {
                    $this->_controllerName = 'index';
                }
                else
                {
                    $this->_controllerName = strtolower(trim($pieces[0], '/'));
                }
            }
            else
            {
                $this->_controllerName = 'index';
            }

            $this->_actionName = strtolower((isset($pieces[1]) && !empty($pieces[1])) ? $pieces[1] : 'index');
            
            $paramsPieces = array_splice($pieces, 2);
            for ($x = 0; $x < count($paramsPieces); $x+=2)
            {
                if (isset($paramsPieces[$x+1]))
                {
                    $this->_requestParams['_path'][$paramsPieces[$x]] = $paramsPieces[$x+1];
                }
            }
        }
    }

    public function getControllerName()
    {
        return strtolower($this->_controllerName);
    }

    public function setControllerName($controllerName)
    {
        $this->_controllerName = $controllerName;
    }

    public function getActionName()
    {
        return strtolower($this->_actionName);
    }

    public function setActionName($actionName)
    {
        $this->_actionName = $actionName;
    }
}
