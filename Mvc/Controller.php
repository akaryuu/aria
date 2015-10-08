<?php

namespace Aria;

/**
* Base class of all controllers
*/

abstract class Mvc_Controller
{
    //DEPRECATED:
    //protected $_view;
    //protected $_layout;
    protected $_request;

    public function __construct()
    {
        $controllerFront = Mvc_FrontController::getInstance();
        $this->_request = $controllerFront->getRequest();
        //DEPRECATED:
        //$this->_layout = $controllerFront->getLayoutTemplate();
        //$this->_view = $controllerFront->getView();
        //$this->_layout->assign('page', isset($this->_breadcrumb) ? $this->_breadcrumb : '');

        $request = array(
	    'controller' => $this->_request->getControllerName(),
	    'action' => $this->_request->getActionName(),
	    'page' => $this->_request->getControllerName() . '_' . $this->_request->getActionName()
        );
	Mvc_View::set('request', $request);
    }

    //DEPRECATED:
    //public function getView()
    //{
    //    return $this->_view;
    //}

    public function getRequest()
    {
        return $this->_request;
    }

    protected function _forward($controller, $action = '') {
        if (empty($action)) {
            $action = $controller;
            $controller = $this->_request->getControllerName();
        }

        Mvc_FrontController::getInstance()->forward($controller, $action);
    }
}
