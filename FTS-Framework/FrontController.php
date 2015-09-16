<?php

namespace FTS;


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

    }
}