<?php

namespace Aria;

/**
 * Router 
 * 
 * @package 
 * @version 0.1
 * @copyright 2012 Marcin Staszewski
 * @author Marcin Staszewski <marcin@mouseinabox.info> 
 */
class Router
{
    protected $_routes;

    public function __construct()
    {
        $config = Registry::getInstance()->get('config');
        $all_routes = json_decode(file_get_contents(ROOT_PATH . 'config/routes.json'), true);
        $this->_routes = $all_routes[$config['module']];
    }

    public function findRoute($uri)
    {
        foreach ($this->_routes as $pattern => $params) {
            if (preg_match('/' . $pattern . '/', $uri, $matches)) {

                $result = array(
                    'success' => true,
                    'controller' => (isset($params['controller']) ? $params['controller'] : null),
                    'action' => (isset($params['action']) ? $params['action'] : null),
                    'params' => (isset($params['static_params']) ? $params['static_params'] : array()), 
                    'redirect' => (isset($params['redirect']) ? $params['redirect'] : null)
                );

                if (!empty($params['dynamic_params'])) {
                    foreach ($params['dynamic_params'] as $key => $param_name) {
                        $result['params'][$param_name] = isset($matches[$key + 1]) ? $matches[$key + 1] : null;
                    }
                }

                return $result;
            }
        }

        return array(
            'success' => false
        );
    }

}
