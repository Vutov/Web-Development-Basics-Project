<?php

namespace FTS;

use FTS\Routers\IRouter;

class FrontController
{
    const DEFAULT_CONTROLLER = 'Index';
    const DEFAULT_METHOD = 'index';

    private static $_instance = null;
    private $_namespace = null;
    private $_controller = null;
    private $_method = null;
    private $_params = array();
    private $_router = null;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new FrontController();
        }

        return self::$_instance;
    }

    public function getRouter(){
        return $this->_router;
    }

    public function setRouter(IRouter $router){
        $this->_router = $router;
    }

    private function getDefaultController()
    {
        $controller = App::getInstance()->getConfig()->app['default_controller'];
        if ($controller) {
            return strtolower($controller);
        }

        return self::DEFAULT_CONTROLLER;
    }

    private function getDefaultMethod()
    {
        $method = App::getInstance()->getConfig()->app['default_method'];
        if ($method) {
            return strtolower($method);
        }

        return self::DEFAULT_METHOD;
    }

    public function dispatch()
    {
        if ($this->_router == null) {
            throw new \Exception('Invalid router!', 500);
        }

        $uri = $this->_router->getURI();
        $routes = App::getInstance()->getConfig()->routes;
        $routeData = null;
        if (is_array($routes) && count($routes) > 0) {
            foreach ($routes as $route => $data) {
                $route = strtolower($route);
                if (stripos($uri, $route) === 0 &&
                    ($uri == $route || stripos($uri, $route . '/') === 0) &&
                    $data['namespace']
                ) {
                    $this->_namespace = $data['namespace'];
                    $routeData = $data;
                    var_dump($this->_namespace);
                    // package found, remove it from uri - example Admin/index/edit/3
                    $uri = substr($uri, strlen($route) + 1);
                    break;
                }
            }
        } else {
            throw new \Exception('Default route missing', 500);
        }

        if ($this->_namespace == null && $routes['*']['namespace']) {
            $this->_namespace = $routes['*']['namespace'];
            $routeData = $routes['*'];
        } else if ($this->_namespace == null && !$routes['*']['namespace']) {
            throw new \Exception('Default route missing', 500);
        }

        $params = explode('/', strtolower($uri));

        // No params means no controller and method as well.
        if ($params[0]) {
            $this->_controller = trim($params[0]);
            if ($params[1]) {
                $this->_method = trim($params[1]);
                unset($params[0], $params[1]);
                foreach ($params as $param) {
                    $param = trim($param);
                    $this->_params[] = $param;
                }
            } else {
                $this->_method = $this->getDefaultMethod();
            }
        } else {
            $this->_controller = $this->getDefaultController();
            $this->_method = $this->getDefaultMethod();
        }

        if (is_array($routeData) &&
            $routeData['controllers']
        ) {
            if ($routeData['controllers'][$this->_controller]['methods'][$this->_method]) {
                $this->_method = strtolower($routeData['controllers'][$this->_controller]['methods'][$this->_method]);
            }

            if (isset($routeData['controllers'][$this->_controller]['goesTo'])) {
                $this->_controller = strtolower($routeData['controllers'][$this->_controller]['goesTo']);
            }
        }

        $file = ucfirst($this->_namespace) . '\\' . ucfirst($this->_controller) . 'Controller';
        $calledController = new $file();
        $calledController->{strtolower($this->_method)}();
    }
}