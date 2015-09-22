<?php

namespace Controllers;

use FTS\BaseController;
use Models\BindingModels\LoginBindingModel;

class IndexController extends BaseController
{
    public function index()
    {
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('login', 'login');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.home');
    }

    /**
     * @Route("test")
     */
    public function create()
    {
        var_dump($this->input->get(0));
        echo 'Create in Index file';
    }

    /**
     * @param LoginBindingModel $model
     * @throws \Exception
     */
    public function login(LoginBindingModel $model)
    {
        var_dump($model);
        die;
        if (isset($this->session->_login)) {
            throw new \Exception("Already logged in!", 400);
        } else {
            $this->db->prepare("
        SELECT id
        FROM users
        WHERE username = ? AND password = ?");
            $this->db->prepare(array($model->getUsername(), $model->getPassword()));
            $id = $this->db->execute()->fetchAllAssoc();
            $this->session->_login = $id;
        }

        var_dump($this->session->login);
    }
}