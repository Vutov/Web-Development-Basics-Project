<?php

namespace FTS;


class View
{

    private static $_instance = null;
    private $_viewPath = null;
    private $_viewDir = null;
    private $_viewBag = array();
    private $_extension = '.php';

    private function __construct()
    {
        $this->_viewPath = App::getInstance()->getConfig()->app['views'];
        if ($this->_viewPath == null) {
            $this->_viewPath = realpath('../Views/');
        }

    }

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new View();
        }

        return self::$_instance;
    }

    public function __get($name)
    {
        return $this->_viewBag[$name];
    }

    public function __set($name, $value)
    {
        $this->_viewBag[$name] = $value;
    }

    public function setViewDirectory($path)
    {
        $path = trim($path);
        if ($path) {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            if (is_dir($path) && is_readable($path)) {
                $this->_viewDir = $path;
            } else {
                throw new \Exception('Problem with view path', 500);
            }
        } else {
            throw new \Exception('Problem with view path', 500);
        }
    }

    public function display($name, $data = array(), $returnAsString = false)
    {
        if (is_array($data)) {
            $this->_viewBag = array_merge($this->_viewBag, $data);
        }

        if ($returnAsString) {
            return $this->includeFile($name);
        } else {
            echo $this->includeFile($name);
        }
    }

    /**
     * Packages must be with starting big letter, views with starting small letters and separated by dot.
     * @param $file string
     * @return string view
     * @throws \Exception when file cannot be found
     */
    public function includeFile($file)
    {
        if ($this->_viewDir == null) {
            $this->setViewDirectory($this->_viewPath);
        }

        $path = str_replace('.', DIRECTORY_SEPARATOR, $file);
        $fullPath = $this->_viewDir . $path . $this->_extension;
        if (file_exists($fullPath) && is_readable($fullPath)) {

            // adds to different buffer
            ob_start();
            include $fullPath;

            // returns the buffer as string
            return ob_get_clean();
        } else {
            throw new \Exception('View ' . $file . ' cannot be included', 500);
        }
    }
}