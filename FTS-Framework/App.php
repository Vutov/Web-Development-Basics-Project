<?php

namespace FTS;
include_once 'Loader.php';

class App{
    private static $_instance = null;
    private $_config = null;
    private $_frontController = null;

    private function __construct(){
        Loader::registerNamespace('FTS', dirname(__FILE__).DIRECTORY_SEPARATOR);
        Loader::registerAutoLoad();
        $this->_config = Config::getInstance();
    }

    public function setConfigFolder($path){
        $this->_config->setConfigFolder($path);
    }

    public function getConfigFolder(){
        return $this->_config->getConfigFolder();
    }

    /**
     * @return App
     */
    public static function getInstance(){
        if (self::$_instance == null) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }

    /**
     * @return Config
     */
    public function getConfig(){
        return $this->_config;
    }

    public function run(){
        if ($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder('../config');
        }

        $this->_frontController = FrontController::getInstance();

        $this->_frontController->dispatch();
    }
}