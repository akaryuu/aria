<?php

namespace Aria;

/**
* Base class of all controllers
*/

abstract class Mvc_Controller_Action
{
    protected $_view;
    protected $_request;
    protected $_layout;

    public function __construct()
    {
        $controllerFront = Mvc_Controller_Front::getInstance();
        $this->_layout = $controllerFront->getLayoutTemplate();
        $this->_view = new Mvc_View();
        $controllerFront->addView($this->_view);
        $this->_request = $controllerFront->getRequest();

        /* Built-in Ajax support to be reviewed */
        //if (preg_match('/^ajax-/', $this->_request->getControllerName()))
        //{
        //    Mvc_Controller_Front::getInstance()->getResponse()->disableLayout();
        //    $this->_view->setDefaultScript(preg_replace('/^ajax-/', '', $this->_request->getControllerName()) . '/' . $this->_request->getActionName() . '.tpl');
        //}
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
}
