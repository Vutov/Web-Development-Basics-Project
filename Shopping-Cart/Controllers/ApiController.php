<?php

namespace Controllers;

use FTS\App;
use FTS\BaseController;
use Models\ViewModels\ApiController\IndexViewModel;

class ApiController extends BaseController
{
    public function index()
    {
        $foundRoutes = array();

        // Config routes
        $configRoutes = App::getInstance()->getConfig()->routes;
        foreach ($configRoutes as $area => $namespace) {
            if ($namespace['controllers']) {
                foreach ($namespace['controllers'] as $controller => $methods) {
                    foreach ($methods['methods'] as $newFunctionRoute => $originalFunction) {
                        $file = App::getInstance()->getConfig()->app['namespaces']['Controllers'];
                        $file = $file . ucfirst($methods['goesTo']) . 'Controller';
                        $file = str_replace('../', '', $file);
                        $file = str_replace('/', '\\', $file);
                        $reflection = new \ReflectionMethod($file, $originalFunction);
                        $doc = $reflection->getDocComment();
                        $params = $this->findBindingModels($doc);

                        $requestMethod = null;
                        if ($methods['requestMethod'][$newFunctionRoute]) {
                            $requestMethod = $methods['requestMethod'][$newFunctionRoute];
                        } else {
                            // Methods without config request - checking controller for annotation
                            if ($methods['goesTo'] && $originalFunction) {
                                preg_match('/@(post|get|put|delete)/', strtolower($doc), $requestMethods);
                                $requestMethod = 'Get';
                                if ($requestMethods[1]) {
                                    $requestMethod = $requestMethods[1];
                                }
                            }
                        }
                        if ($area === '*') {
                            $route = '@' . strtoupper($requestMethod) . ' ' .
                                strtolower($controller . '/' . $newFunctionRoute);
                        } else {
                            $route = '@' . strtoupper($requestMethod) . ' ' .
                                strtolower($area . '/' . $controller . '/' . $newFunctionRoute);
                        }

                        $foundRoutes[$route] = $params;
                    }
                }
            }
        }

        // Custom routes and not listed ones
        $controllersFolder = App::getInstance()->getConfig()->app['namespaces']['Controllers'];
        $allFiles = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($controllersFolder));
        $phpFiles = new \RegexIterator($allFiles, '/\.php$/');
        foreach ($phpFiles as $file) {
            $controllerPath = str_replace('../', '', $file->getPathName());
            $controllerPath = str_replace('.php', '', $controllerPath);
            $normalizedPath = str_replace('/', '\\', $controllerPath);
            $reflectionController = new \ReflectionClass(new $normalizedPath);
            $methods = $reflectionController->getMethods();
            foreach ($methods as $method) {
                $doc = $method->getDocComment();
                @$params = $this->findBindingModels($doc);
                $doc = strtolower($doc);
                preg_match('/@route\("(.*)"\)/', $doc, $matches);
                preg_match('/@(post|get|put|delete)/', $doc, $requestMethods);
                $route = $matches[1];
                $requestMethod = 'Get';
                if ($requestMethods[1]) {
                    $requestMethod = $requestMethods[1];
                }

                if ($route) {
                    $fullRoute = '@' . strtoupper($requestMethod) . ' ' . strtolower($route);
                    $foundRoutes[$fullRoute] = $params;
                }
            }
        }

        $this->view->display(new IndexViewModel($foundRoutes));
    }


    private function findBindingModels($doc)
    {
        $params = array();
        if (preg_match('/@param\s+\\\?([\s\S]+BindingModel)\s+\$/', $doc, $match)) {
            $bindingModelName = $match[1];
            $bindingModelsNamespace = App::getInstance()->getConfig()->app['namespaces']['Models'] . 'BindingModels/';
            $bindingModelsNamespace = str_replace('../', '', $bindingModelsNamespace);
            $bindingModelPath = str_replace('/', '\\', $bindingModelsNamespace . $bindingModelName);
            $bindingReflection = new \ReflectionClass($bindingModelPath);
            $properties = $bindingReflection->getProperties();
            foreach ($properties as $property) {
                $name = $property->getName();
                $params[$name] = $name;
            }
            return $params;
        }

        return $params;
    }
}