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
    protected static $_vars = array();

    public static function render()
    {
        $request = Mvc_FrontController::getInstance()->getRequest();

        $templateDir = APPLICATION_PATH . '/View/';
        $templateScript = $request->getControllerName() . '/' . $request->getActionName() . '.twig';
	$templateCacheDir = ROOT_PATH . 'var/cache';

	$loader = new \Twig_Loader_Filesystem($templateDir);
	$twig = new \Twig_Environment($loader, array('cache' => $templateCacheDir));
	echo $twig->render($templateScript, array('vars' => self::$_vars));
    }

    public static function set($key, $value)
    {
	self::$_vars[$key] = $value;
    }

    public static function setDefaultScript($script)
    {
        self::$_templateScript = $script;
    }
}
