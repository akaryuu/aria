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
        $this->_uri = $this->_parseUri();
        $this->_userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->_serverName = $_SERVER['SERVER_NAME'];
        $this->_serverAddr = $_SERVER['SERVER_ADDR'];
        $this->_serverPort = $_SERVER['SERVER_PORT'];
        $this->_remoteAddr = $_SERVER['REMOTE_ADDR'];
        $this->_requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->_requestParams = array();
        //unset($_SESSION);
        //unset($_SERVER);
        //unset($_REQUEST);
        //unset($_POST);
        //unset($_GET);

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


    public function getParams($scope = '')
    {
        if (!empty($scope)) {
            return array_merge($this->_requestParams['_path'], $this->_requestParams['_post'], $this->_requestParams['_get']);
        } else {
            return isset($this->_requestParams[$scope]) ? $this->_requestParams[$scope] : false;
        }
    }

    public function getParam($name, $scope = '')
    {
        if (!empty($scope)) {
            return (!empty($this->_requestParams[$scope][$name]) ? $this->_requestParams[$scope][$name] : false);         
        }

        foreach ($this->_requestParams as $key) {
            if (is_array($this->_requestParams[$key]) && !empty($this->_requestParms[$key][$name])) {
                return $this->_requestParams[$key][$name];
            } else if ($key === $name) {
                return $this->_requestParams[$name];
            }
        }

        return false;
    }

    public function isGet()
    {
        return $this->_requestMethod === 'GET' ? true : false;
    }

    public function isPost()
    {
        return $this->_requestMethod === 'POST' ? true : false;
    }

    protected function _parseUri()
    {
        return defined('SCRIPT_PATH') ? substr($_SERVER['REQUEST_URI'], strlen(SCRIPT_PATH)) : $_SERVER['REQUEST_URI'];
    }
}
