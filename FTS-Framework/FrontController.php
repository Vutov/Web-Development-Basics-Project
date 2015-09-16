<?php

namespace FTS;


use FTS\Routers\DefaultRouter;

class FrontController
{
    const DEFAULT_CONTROLLER = 'Index';
    const DEFAULT_METHOD = 'index';

    private static $_instance = null;
    private $_namespace = null;
    private $_controller = null;
    private $_method = null;
    private $_params = array();

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

    public function dispatch()
    {
        $router = new DefaultRouter();
        $uri = $router->getURI();
        $routes = App::getInstance()->getConfig()->routes;
        $routeData = null;
        if (is_array($routes) && count($routes) > 0) {
            foreach ($routes as $route => $data) {
                if (stripos($uri, $route) === 0 &&
                    ($uri == $route || stripos($uri, $route . '/') === 0) &&
                    $data['namespace']
                ) {
                    $this->_namespace = $data['namespace'];
                    $routeData = $data;

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
            $routeData['controllers'] &&
            $routeData['controllers'][$this->_controller]['goesTo']
        ) {
            if ($routeData['controllers'][$this->_controller]['methods'][$this->_method]) {
                $this->_method = $routeData['controllers'][$this->_controller]['methods'][$this->_method];
            }

            $this->_controller = $routeData['controllers'][$this->_controller]['goesTo'];
        }

        $file = ucfirst($this->_namespace) . '\\' . ucfirst($this->_controller);
        $calledController = new $file();
        $calledController->{strtolower($this->_method)}();
    }

    private function getDefaultController()
    {
        $controller = App::getInstance()->getConfig()->app['default_controller'];
        if ($controller) {
            return $controller;
        }

        return self::DEFAULT_CONTROLLER;
    }

    private function getDefaultMethod()
    {
        $method = App::getInstance()->getConfig()->app['default_method'];
        if ($method) {
            return $method;
        }

        return self::DEFAULT_METHOD;
    }
}