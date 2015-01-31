<?php

namespace Aria;

/**
 * Exception 
 *
 * Main class for Exception handling
 *
 * @uses Exception
 * @package My_Exception 
 * @version 0.1
 * @copyright 2012 Marcin STaszewski
 * @author Marcin Staszewski <marcin@mouseinabox.info> 
 */
class Exception extends \Exception
{
    protected $_message;
    protected $_view;

    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

    public static function exceptionHandler(\Exception $e)
    {
        echo '<h1>Exception:</h1>File: ' . $e->getFile() . ' : ' . $e->getLine() . '<br />Code ' . $e->getCode() . ': <span style="color:red;">' . $e->getMessage() . '</span><br /><br />';
        echo 'Trace:<br/><pre>' . $e->getTraceAsString() . '</pre><br /><br />';
        echo 'SERVER data:';
        Tools::dump($_SERVER);
        echo 'GET data:';
        Tools::dump($_GET);
        echo 'POST data:';
        Tools::dump($_POST);
        if (isset($_SESSION))
        {
            echo 'SESSION data:';
            Tools::dump($_SESSION);
        }
    }

    public static function silentExceptionHandler(Exception $e)
    {
        echo 'Error occured while loading the page. We\'re sorry.<br />If this error will not dissappear in few minutes please contact administrator: admin@mouseinabox.info';
        //TODO: Implement logging
    }
}
