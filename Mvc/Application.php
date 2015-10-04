<?php

namespace Aria;

/**
 * Mvc_Application 
 *
 * This class initializes Loader, Front Controller, Template engine and runs an application
 * 
 * @package Mvc_Application 
 * @version 0.1
 * @copyright 2012 Marcin Staszewski
 * @author Marcin Staszewski <marcin@mouseinabox.info> 
 */
class Mvc_Application
{
	protected $_templateEngine;
	protected $_frontController;
    protected $_requestUrl;
	protected $_domain;
	protected $_module;

	public function __construct()
	{
		$this->_domain = null;
        $this->_requestUrl = preg_match('/[a-z]+/', SCRIPT_PATH) ? $_SERVER['SERVER_NAME'] . SCRIPT_PATH : $_SERVER['SERVER_NAME'];
		$domainsConfig = json_decode(file_get_contents(ROOT_PATH . 'config/domains.json'), true);
        foreach ($domainsConfig as $domain => $config) {
            if (preg_match('/' . preg_replace('/\//', '\/', $domain) . '$/', $this->_requestUrl)) {
                $this->_domain = $domain;
            }
        }
        if (!$this->_domain) {
            throw new Exception("This domain does not exist in configuration");
        }
        Registry::getInstance()->set('config', $domainsConfig[$this->_domain]);
		$this->_module = $domainsConfig[$this->_domain]['module'];
		defined('APPLICATION_PATH') || define('APPLICATION_PATH', ROOT_PATH . 'application/' . $this->_module);
		set_include_path(get_include_path() . PATH_SEPARATOR . APPLICATION_PATH);
		$this->_frontController = Mvc_FrontController::getInstance();
		$this->_templateEngine = new Template();

        // Initializing module default database
        if (isset($domainsConfig[$this->_domain]['db'])) { 
            $this->_database = new Db($domainsConfig[$this->_domain]['db']);
            Registry::getInstance()->set('database', $this->_database);
        }
    }

	public function run()
	{
		$this->_frontController->startMVC($this->_module);
	}
}
