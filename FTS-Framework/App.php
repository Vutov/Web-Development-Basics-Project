<?php

namespace FTS;

use FTS\Routers\DefaultRouter;
use FTS\Routers\IRouter;

include_once 'Loader.php';

class App
{
    private static $_instance = null;
    private $_config = null;
    private $_frontController = null;
    private $_router = null;

    private function __construct()
    {
        Loader::registerNamespace('FTS', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        Loader::registerAutoLoad();
        $this->_config = Config::getInstance();
    }

    public function getConfigFolder()
    {
        return $this->_config->getConfigFolder();
    }

    public function setConfigFolder($path)
    {
        $this->_config->setConfigFolder($path);
    }

    public function getRouter()
    {
        return $this->_router;
    }

    function setRouter($router)
    {
        $this->_router = $router;
    }

    /**
     * @return App
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->_config;
    }

    public function run()
    {
        if ($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder('../config');
        }

        $this->_frontController = FrontController::getInstance();
        if ($this->_router instanceof IRouter) {
            $this->_frontController->setRouter($this->_router);
        } else {
            switch ($this->_router) {
                case 'JsonRPCRouter':
                    //TODO implement JsonRPCRouter
                    $this->_frontController->setRouter(new DefaultRouter());
                    break;
                case 'RPCRouter':
                    //TODO implement RPCRouter
                    $this->_frontController->setRouter(new DefaultRouter());
                    break;
                default:
                    $this->_frontController->setRouter(new DefaultRouter());
                    break;
            }
        }

        $this->_frontController->dispatch();
    }
}