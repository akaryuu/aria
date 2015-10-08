<?php

namespace Aria;

class Bootstrap
{
    public static function boot($config_folder_path)
    {
        date_default_timezone_set('Europe/Warsaw'); 
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');

        if (file_exists($config_folder_path)) {
            define('CONFIG_PATH', $config_folder_path);
        }
        $config = array();

        foreach (new \RecursiveDirectoryIterator(CONFIG_PATH, \FilesystemIterator::SKIP_DOTS) as $filename)
        {
            if (preg_match('/.*\/([a-z\-]+).json$/', $filename, $matches)) {
                $config[$matches[1]] = json_decode(file_get_contents($filename), true);
            }
        } 

        isset($config['config']) || $config['config'] = array();

        isset($config['config']['root_path']) || 
            ($config['config']['root_path'] = './');
        isset($config['config']['libs_path']) || 
            ($config['config']['libs_path'] = $config['config']['root_path'] . './libs');
        isset($config['config']['aria_path']) ||
            ($config['config']['aria_path'] = $config['config']['libs_path'] . './Aria');

        define('ROOT_PATH', $config['config']['root_path']);
        define('LIBRARY_PATH', $config['config']['libs_path']);
        define('ARIA_PATH', $config['config']['aria_path']);

        (isset($config['config']['script_path']) && define('SCRIPT_PATH', $config['config']['script_path'])) || define('SCRIPT_PATH', '/');

        set_include_path(get_include_path() . PATH_SEPARATOR . LIBRARY_PATH);

        require_once(ARIA_PATH . 'Exception.php');
        set_exception_handler(array('\Aria\Exception','exceptionHandler'));

        // Smarty Template system include
        //require_once('Smarty-3.1.14/libs/Smarty.class.php');
	// Twig Template System
	require_once('Twig-1.22.1/lib/Twig/Autoloader.php');
	\Twig_Autoloader::register();		
        // Doctrine ORM include
        // require_once('Doctrine/ORM/Tools/Setup.php');

        require_once(ARIA_PATH . 'Loader.php');
        new \Aria\Loader();

        $default_config = \Aria\Mvc_Config_Default::get();
        $config['config'] = array_replace_recursive($default_config, $config['config']);

        \Aria\Registry::getInstance()->set('config', $config);

        $application = new \Aria\Mvc_Application();
        $application->run();
    }

}

