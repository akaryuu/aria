<?php

namespace Aria;

/**
* Base class of all controllers
*/

abstract class Mvc_Controller
{
    protected $_view;
    protected $_request;
    protected $_layout;

    public function __construct()
    {
        $controllerFront = Mvc_FrontController::getInstance();
        $this->_layout = $controllerFront->getLayoutTemplate();
        $this->_request = $controllerFront->getRequest();
        $this->_view = $controllerFront->getView();

        $this->_layout->assign('currentPage', isset($this->_breadcrumb) ? $this->_breadcrumb : '');
    }

    public function getView()
    {
        return $this->_view;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function setDispatched($dispatched)
    {

    }

    protected function _forward($controller, $action = '') {
        if (empty($action)) {
            $action = $controller;
            $controller = $this->_request->getControllerName();
        }

        Mvc_FrontController::getInstance()->forward($controller, $action);
    }
}
