<?php

namespace Aria;

class Template extends \Smarty
{
    protected $_smarty; // Smarty template engine main object
    protected $_response; // Core Response object

    public function __construct()
    {
        parent::__construct();
        $this->_response = Mvc_Controller_Front::getInstance()->getResponse();
        $this->setTemplateDir(APPLICATION_PATH . '/View/');
        $this->setCompileDir(ROOT_PATH . 'var/templates_c/');
        $this->setConfigDir(ROOT_PATH . 'var/configs/');
        $this->setCacheDir(ROOT_PATH . 'var/cache/');
        $this->addPluginsDir(ROOT_PATH . 'SmartyPlugins/');
        //$this->testInstall();
    }


    public function render($tpl_name)
    {
        try {
            $tpl = $this->fetch($tpl_name);
            //My_Tools::debug($tpl, __METHOD__);
            $this->_response->append($this->fetch($tpl_name));
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

}
