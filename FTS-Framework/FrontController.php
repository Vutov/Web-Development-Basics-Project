<?php

namespace FTS;


use FTS\Routers\DefaultRouter;

class FrontController {
    private  static  $_instance = null;

    private function __construct(){

    }

    public static function getInstance(){
        if (self::$_instance == null) {
            self::$_instance = new FrontController();
        }

        return self::$_instance;
    }

    /**
     * Takes needed router
     */
    public function dispatch(){
        $router = new DefaultRouter();
        $router->parse();
        var_dump($router->getController());
    }
}