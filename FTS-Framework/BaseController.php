<?php

namespace FTS;


use FTS\DB\SimpleDB;
use FTS\Sessions\ISession;

class BaseController
{

    /**
     * @var App
     */
    protected $app;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var InputData
     */
    protected $input;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * Default Db connection used
     * @var SimpleDB
     */
    protected $db;

    /**
     * @var ISession
     */
    protected $session;

    public function __construct()
    {
        $this->app = App::getInstance();
        $this->view = View::getInstance();
        $this->config = $this->app->getConfig();
        $this->input = InputData::getInstance();
        $this->validator = new Validator();
        $this->db = new SimpleDB();
        $this->session = $this->app->getSession();
    }

    protected function redirect($uri){
        header("Location: $uri");
    }

    protected function checkForNotLogged(){
        if ($this->session->_login) {
            throw new \Exception("Already logged in!", 400);
        }
    }
}