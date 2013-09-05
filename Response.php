<?php

namespace Aria;

class Response
{
    /**
     * _responseBody 
     * 
     * This variable contains whole content of the page
     *
     * @var string
     * @access protected
     */
    protected $_responseBody; 

    protected $_layoutDisabled;

    public function append($html)
    {
        $this->_responseBody .= $html;
    }

    public function output()
    {
        if ($this->_layoutDisabled)
        {
            echo $this->getHtml();
        }
        else
        {
            $template = Mvc_Controller_Front::getInstance()->getLayoutTemplate();
            $template->assign('content', $this->getHtml());
            $template->display('layout.tpl');
        }
    }

    public function getHtml()
    {
        return $this->_responseBody;
    }

    public function disableLayout()
    {
        $this->_layoutDisabled = true;
    }
}
