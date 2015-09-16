<?php

namespace FTS;


use FTS\Routers\DefaultRouter;

class FrontController
{
    const DEFAULT_CONTROLLER = 'Index';
    const DEFAULT_METHOD = 'index';

    private static $_instance = null;

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

    /**
     * Takes needed router
     */
    public function dispatch()
    {
        $router = new DefaultRouter();
        $router->parse();
        $controller = $router->getController();
        if ($controller == null) {
            $controller = $this->getDefaultController();
        }

        $method = $router->getMethod();
        if ($method == null) {
            $method = $this->getDefaultMethod();
        }

        var_dump($controller);
        var_dump($method);
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