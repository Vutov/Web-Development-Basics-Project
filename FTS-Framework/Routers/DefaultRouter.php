<?php

namespace FTS\Routers;


class DefaultRouter {

    private $_controller = null;
    private $_method = null;
    private $_params = array();

    public function parse()
    {
        $uri = substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1);
        $uri = trim($uri);
        $params = explode('/', $uri);

        // No params means no controller and method as well.
        if ($params[0]) {
            $this->_controller = ucfirst(trim(strtolower($params[0])));
            if ($params[1]) {
                $this->_method = strtolower(trim($params[1]));
                unset($params[0], $params[1]);
                foreach ($params as $param) {
                    $param = trim($param);
                    $this->_params[] = strtolower($param);
                }
            }
        }
    }

    public function getController(){
        return $this->_controller;
    }

    public function getMethod(){
        return $this->_method;
    }

    public function getGetParams(){
        return $this->_params;
    }
}