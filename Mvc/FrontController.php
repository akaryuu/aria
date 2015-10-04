<?php

namespace Aria;

class Mvc_FrontController
{
    private static $_instance;
    protected $_controllersPath;
    protected $_request;
    protected $_response;
    protected $_module;
    protected $_layout;
    protected $_view;

    protected function __construct()
    {
        $this->_request = new Mvc_Request();
        $this->_response = new Response();
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof Mvc_FrontController))
        {
            self::$_instance = new Mvc_FrontController();
        }
        return self::$_instance;
    }

    public function startMVC($module)
    {
        $this->_layout = new Template();
        $this->_module = $module;
        $this->_controllersPath = APPLICATION_PATH . '/Controller/';
        $controllerName = ucfirst($this->_request->getControllerName());
        $session = Session::getInstance();

        $this->forward($controllerName, $this->_request->getActionName());

        $this->_view->render();

        echo $this->_response->output();
    }

    public function forward($controllerName, $actionName) {

        $this->_request->setControllerName($controllerName);
        $this->_request->setActionName($actionName);

        $this->_view = new Mvc_View();

        $controllerName = ucfirst($controllerName);

        if (file_exists($this->_controllersPath . $controllerName . '.php') && ctype_alpha($controllerName))
        {
            $controllerClass = 'Application_Controller_' . $controllerName;
            $controller = new $controllerClass($controllerName);
            $actionFunc = preg_replace('/\-(.)/e', "strtoupper('\\1')", $actionName) . 'Action';
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
            throw new Exception("Controller file $controllerName.php does not exist in $this->_module module !");
        }
    }

    public function getLayoutTemplate()
    {
        return $this->_layout;
    }

    public function setView(Mvc_View $view)
    {
        //$this->_views[] = $view;
        $this->_view = $view;
    }

    public function getView()
    {
        return $this->_view;
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
