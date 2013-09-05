<?php

namespace Aria;

class Mvc_Controller_Front
{
    private static $_instance;
    protected $_controllersPath;
    protected $_request;
    protected $_response;
    protected $_module;
    protected $_layout;
    protected $_views = array();

    protected function __construct()
    {
        $this->_request = new Request();
        $this->_response = new Response();
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof Mvc_Controller_Front))
        {
            self::$_instance = new Mvc_Controller_Front();
        }
        return self::$_instance;
    }

    public function startMVC($module)
    {
        $this->_layout = new Template();
        $this->_module = $module;
        $this->_controllersPath = APPLICATION_PATH . '/Controller/';
        // Using eval modifier is deprecated
        // $controllerName = ucfirst(preg_replace(array('/-(.)/e', '/^ajax/'), array('strtoupper(\'\\1\')', ''), $this->_request->getControllerName()));
        $controllerName = ucfirst($this->_request->getControllerName());
        $session = Session::getInstance();

        if (file_exists($this->_controllersPath . $controllerName . '.php') && ctype_alpha($controllerName))
        {
            $controllerClass = 'Application_Controller_' . $controllerName;
            $controller = new $controllerClass($controllerName);
            $actionFunc = preg_replace('/\-(.)/e', "strtoupper('\\1')", $this->_request->getActionName()) . 'Action';
            if (!method_exists($controller, $actionFunc) || !ctype_alpha($actionFunc))
            {
                throw new Exception("Action {$actionFunc} doesn't exists in controller $controllerName");
            }
            else
            {
                $controller->{$actionFunc}();
            }
        }
        else
        {
            throw new Exception("Controller file $controllerName.php does not exist in $module module !");
        }

        foreach ($this->_views as $view)
        {
            $view->render();
        }
        echo $this->_response->output();
    }

    public function getLayoutTemplate()
    {
        return $this->_layout;
    }

    public function addView(Mvc_View $view)
    {
        $this->_views[] = $view;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function getResponse()
    {
        return $this->_response;
    }
}
