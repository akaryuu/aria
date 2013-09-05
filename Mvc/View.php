<?php

namespace Aria;

/**
 * Mvc_View 
 * 
 * This class takes care of the presentation part of the page
 *
 * @package View
 * @version 0.1
 * @copyright 2012 Marcin STaszewski
 * @author Marcin Staszewski <marcin@mouseinabox.info> 
 */
class Mvc_View
{
    protected $_templateScript;
    protected $_template; // Template engine object
    protected $_noRender;

    public function __construct()
    {
        $request = Mvc_Controller_Front::getInstance()->getRequest();
        $this->_templateScript = $request->getControllerName() . '/' . $request->getActionName() . '.tpl';
        $this->_template = new Template();

    }

    public function render($script = NULL)
    {
        if ($this->_noRender)
        {
            return;
        }

        if ($script == NULL)
        {
            $this->_template->render($this->_templateScript);
        }
        else
        {
            $this->_template->render($script);
        }
    }

    public function assign($label, $value)
    {
        $this->_template->assign($label, $value);
    }

    public function setDefaultScript($script)
    {
        $this->_templateScript = $script;
    }

    public function setNoRender()
    {
        $this->_noRender = true;
    }
}
