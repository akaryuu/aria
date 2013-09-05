<?php

namespace Aria;

class Request
{
    protected $__session;
    protected $_server;
    protected $_request;
    protected $_post;
    protected $_get;
    protected $_host;
    protected $_uri;
    protected $_userAgent;
    protected $_serverName;
    protected $_serverAddr;
    protected $_serverPort;
    protected $_remoteAddr;
    protected $_requestMethod;
    protected $_controlleriName;
    protected $_actionName;
    protected $_requestParams;

    public function __construct()
    {
        $this->_session = isset($_SESSION) ? $_SESSION : null;
        $this->_server = $_SERVER;
        $this->_request = $_REQUEST;
        $this->_post = $_POST;
        $this->_get = $_GET;
        $this->_host = $_SERVER['HTTP_HOST'];
        $this->_uri = defined('SCRIPT_PATH') ? substr($_SERVER['REQUEST_URI'], strlen(SCRIPT_PATH)) : $_SERVER['REQUEST_URI'];
        $this->_userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->_serverName = $_SERVER['SERVER_NAME'];
        $this->_serverAddr = $_SERVER['SERVER_ADDR'];
        $this->_serverPort = $_SERVER['SERVER_PORT'];
        $this->_remoteAddr = $_SERVER['REMOTE_ADDR'];
        $this->_requestMethod = $_SERVER['REQUEST_METHOD'];
        //unset($_SESSION);
        //unset($_SERVER);
        //unset($_REQUEST);
        //unset($_POST);
        //unset($_GET);

        $pieces = explode('?', $this->_uri);
        $pieces = explode(',', $pieces[0]);

        if (isset($pieces[0]) && !empty($pieces[0]))
        {
            if ($pieces[0] == '/')
            {
                $this->_controllerName = 'index';
            }
            else
            {
                $this->_controllerName = trim($pieces[0], '/');
            }
        }
        else
        {
            $this->_controllerName = 'index';
        }

        $this->_actionName = (isset($pieces[1]) && !empty($pieces[1])) ? $pieces[1] : 'index';
        
        $paramsPieces = array_splice($pieces, 2);
        $this->_requestParams = array();
        for ($x = 0; $x < count($paramsPieces); $x+=2)
        {
            if (isset($paramsPieces[$x+1]))
            {
                $this->_requestParams[$paramsPieces[$x]] = $paramsPieces[$x+1];
            }
        }
		$this->_requestParams['_post'] = $this->_post;
		$this->_requestParams['_get'] = $this->_get;

    }

    public function getRequestUri()
    {
        return $this->_uri;
    }

    public function getSession()
    {
        return $this->_session;
    }

    public function getServer()
    {
        return $this->_server;
    }

    public function getControllerName()
    {
        return $this->_controllerName;
    }

    public function setControllerName($controllerName)
    {
        $this->_controllerName = $controllerName;
    }

    public function getActionName()
    {
        return $this->_actionName;
    }

    public function getParams($scope = 'all')
    {
        switch ($scope) {
        case 'all':
            return $this->_requestParams;
        case 'get':
            return $this->_requestParams['_get'];
        case 'post':
            return $this->_requestParams['_post'];
        }

    }

    public function getParam($name, $scope = 'all') // Possible scopes: all, get, post
    {
        /* Currently scope is not supported. Todo */
        if (isset($this->_requestParams[$name])) {
            return $this->_requestParams[$name];
        }
        if (isset($this->_requestParams['_post'][$name])) {
            return $this->_requestParams['_post'][$name];
        }
        if (isset($this->_requestParams['_get'][$name])) {
            return $this->_requestParams['_get'][$name];
        }
        
    }

    public function isPost()
    {
        return $this->_requestMethod === 'POST' ? true : false;
    }
}
