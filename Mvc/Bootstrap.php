<?php

namespace Aria;

class Bootstrap
{
    public static function boot($config_folder_path)
    {
        date_default_timezone_set('Europe/Warsaw'); 
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');

        define('CONFIG_PATH', $config_folder_path);
		$config = json_decode(file_get_contents($config_folder_path . 'config.json'), true);

        self::_setOptionsFromConfig($config);

        set_include_path(get_include_path() . PATH_SEPARATOR . LIBRARY_PATH);

        require_once(ARIA_PATH . 'Exception.php');
        set_exception_handler(array('\Aria\Exception','exceptionHandler'));

        // Smarty Template system include
        require_once('Smarty-3.1.14/libs/Smarty.class.php');
        // Doctrine ORM innclude
        // require_once('Doctrine/ORM/Tools/Setup.php');

        require_once(ARIA_PATH . 'Loader.php');
        new \Aria\Loader();

        \Aria\Registry::getInstance()->set('config', $config);

        $application = new \Aria\Mvc_Application();
        $application->run();
    }

    protected static function _setOptionsFromConfig($config)
    {
        (isset($config['root_path']) && define('ROOT_PATH', $config['root_path'])) || define('ROOT_PATH', './');
        (isset($config['libs_path']) && define('LIBRARY_PATH', $config['libs_path'])) || define('LIBRARY_PATH', ROOT_PATH . './libs/');
        (isset($config['aria_path']) && define('ARIA_PATH', $config['aria_path'])) || define('ARIA_PATH', LIBRARY_PATH . './Aria/');
        (isset($config['script_path']) && define('SCRIPT_PATH', $config['script_path'])) || define('SCRIPT_PATH', '/');
    }
}

