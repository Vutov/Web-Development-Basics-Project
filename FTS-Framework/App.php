<?php

namespace FTS;

use FTS\Routers\DefaultRouter;
use FTS\Routers\IRouter;
use FTS\Sessions\ISession;
use FTS\Sessions\NativeSession;

include_once 'Loader.php';

class App
{
    private static $_instance = null;
    private $_config = null;
    private $_frontController = null;
    private $_router = null;
    private $_dbConnections = array();
    private $_session = null;

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

    public function getDbConnection($connection = 'default')
    {
        if (!$connection) {
            throw new \Exception('No connection string provided', 500);
        }

        if ($this->_dbConnections[$connection]) {
            return $this->_dbConnections[$connection];
        }

        $dbConfig = $this->getConfig()->database;
        if (!$dbConfig[$connection]) {
            throw new \Exception('No valid connection string found in config file', 500);
        }

        $database = new \PDO(
            $dbConfig[$connection]['connection_url'],
            $dbConfig[$connection]['username'],
            $dbConfig[$connection]['password'],
            $dbConfig[$connection]['pdo_options']
        );
        $this->_dbConnections[$connection] = $database;
        return $database;
    }

    /**
     * @return ISession
     */
    public function getSession()
    {
        return $this->_session;
    }

    public function setSession(ISession $session)
    {
        $this->_session = $session;
    }

    public function run()
    {
        if ($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder('../config');
        }

        $this->_frontController = FrontController::getInstance();
        if ($this->_router instanceof IRouter) {
            $this->_frontController->setRouter($this->_router);
        }

        if ($this->_router == null) {
            // Can add here more routers
            $this->_frontController->setRouter(new DefaultRouter());
        }

        if ($this->_session == null) {
            $sessionInfo = $this->_config->app['session'];
            if ($sessionInfo['auto_start']) {
                if ($sessionInfo['type'] == 'native') {
                    $this->_session = new NativeSession(
                        $sessionInfo['name'],
                        $sessionInfo['lifetime'],
                        $sessionInfo['path'],
                        $sessionInfo['domain'],
                        $sessionInfo['secure']
                    );
                }
            }
        }

        $this->_frontController->dispatch();
    }
}