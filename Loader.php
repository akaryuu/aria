<?php

namespace Aria;

/**
 * Loader 
 *
 * Main loader for the classes
 * 
 * @package 
 * @version 0.1
 * @copyright 2012 Marcin STaszewski
 * @author Marcin Staszewski <marcin@mouseinabox.info> 
 */
class Loader
{
	public function __construct()
	{	
		// Initialize Doctrine autoload
        	// Doctrine\ORM\Tools\Setup::registerAutoloadDirectory(LIBRARY_PATH);
		spl_autoload_register(array($this, '_autoload'));
	}

	public function _autoload($classname)
	{
        $classnameWithoutNs = str_replace('Aria\\', '', $classname);
		$pathArray = explode('_', $classnameWithoutNs);

        if ($pathArray[0] == 'Application')
        {
            $pathArray[0] = APPLICATION_PATH;
        }
        else
        {
            $pathArray[0] = LIBRARY_PATH . '/Aria/' . $pathArray[0];
        }

        if (file_exists(implode('/', $pathArray) . '.php'))
        {
            require_once(implode('/', $pathArray) . '.php');
                if (!class_exists($classname))
                {
                    throw new Exception('Class ' . $classname . ' not found :/');
                }
        }
        else
        {
            throw new Exception('Class file ' . implode('/', $pathArray) . '.php doesn\'t exist :/');
        }
	}

}