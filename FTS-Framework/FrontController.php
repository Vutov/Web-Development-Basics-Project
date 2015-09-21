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
    private $_scannedControllers = array();
    private $_customRoutes = array();
    /**
     * @var IRouter
     */
    private $_router = null;

    private function __construct()
    {
        $this->ScanCustomRoutes();
    }

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new FrontController();
        }

        return self::$_instance;
    }

    public function getRouter()
    {
        return $this->_router;
    }

    public function setRouter(IRouter $router)
    {
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

        // Check for custom routes in annotations
        if (array_key_exists($uri, $this->_customRoutes)) {
            $input = InputData::getInstance();
            $input->setGet($uri);
            $input->setPost($this->_router->GetPost());
            $file = $this->_customRoutes[$uri]['Controller'];
            $calledController = new $file();
            $calledController->{strtolower($this->_customRoutes[$uri]['Method'])}();
        } else {
            // Check for config routes
            $this->checkForConfigRoute($uri);
        }
    }

    private function ScanCustomRoutes()
    {
        if (count($this->_scannedControllers) == 0) {
            $controllersFolder = App::getInstance()->getConfig()->app['namespaces']['Controllers'];
            $allFiles = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($controllersFolder));
            $phpFiles = new \RegexIterator($allFiles, '/\.php$/');
            foreach ($phpFiles as $file) {
                $controllerPath = str_replace('../', '', $file->getPathName());
                $controllerPath = str_replace('.php', '', $controllerPath);
                $normalizedPath = str_replace('/', '\\', $controllerPath);
                if (!array_key_exists($normalizedPath, $this->_scannedControllers)) {
                    $this->_scannedControllers[] = $normalizedPath;
                    $reflectionController = new \ReflectionClass(new $normalizedPath);
                    $methods = $reflectionController->getMethods();
                    foreach ($methods as $method) {
                        preg_match_all('/@Route\("(.*)"\)/', $method->getDocComment(), $matches);
                        $routes = $matches[1];
                        foreach ($routes as $route) {
                            if (array_key_exists(strtolower($route), $this->_customRoutes)) {
                                throw new \Exception("Route '" . $route . "' already defined in '" .
                                    $this->_customRoutes[$route] . "'", 500);
                            }

                            $this->_customRoutes[strtolower($route)] = array('Controller' => $normalizedPath, 'Method' => $method->getName());
                        }
                    }
                }
            }
        }
    }

    private function checkForConfigRoute($uri)
    {
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

        $input = InputData::getInstance();
        $params = explode('/', strtolower($uri));

        // No params means no controller and method as well.
        if ($params[0]) {
            $this->_controller = trim($params[0]);
            if ($params[1]) {
                $this->_method = trim($params[1]);
                unset($params[0], $params[1]);
                $input->setGet(array_values($params));
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

        $input->setPost($this->_router->GetPost());

        $file = ucfirst($this->_namespace) . '\\' . ucfirst($this->_controller) . 'Controller';
        $realPath = str_replace('\\', DIRECTORY_SEPARATOR, '../' . $file . '.php');
        $realPath = realpath($realPath);
        if (file_exists($realPath) && is_readable($realPath)) {
            $calledController = new $file();
            if (method_exists($calledController, $this->_method)) {
                $calledController->{strtolower($this->_method)}();
            } else {
                throw new \Exception("'" . $this->_method . "' not found in '" . $file . '.php', 404);
            }
        } else {
            throw new \Exception("File '" . $file . '.php' . "' not found!", 404);
        }
    }
}