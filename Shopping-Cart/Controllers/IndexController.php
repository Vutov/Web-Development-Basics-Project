<?php

namespace Controllers;

use FTS\BaseController;
use Models\BindingModels\LoginBindingModel;

class IndexController extends BaseController
{
    public function index()
    {
        $this->view->appendToLayout('header', 'header');
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
        var_dump($model->getUsername());
        var_dump($model->getPassword());
        var_dump($this->session->_login);
        if ($this->session->_login) {
            throw new \Exception("Already logged in!", 400);
        }

        $this->db->prepare("SELECT id
                                FROM users
                                WHERE username = ? AND password = ?", array($model->getUsername(), $model->getPassword()));
        $response = $this->db->execute()->fetchRowAssoc();
        $id = $response['id'];
        $this->session->_login = $id;


        var_dump($this->session->_login == 4);
    }

    /**
     * @Authorize error:("You are not logged in")
     * @throws \Exception
     */
    public function logout()
    {
        $this->session->destroySession();
        $this->redirect('/');
    }

    public function register()
    {
//        $this->db->prepare(" INSERT INTO users (
//                                id ,
//                                username ,
//                                password ,
//                                isAdmin
//                                )
//                                VALUES (
//                                '4', ?, ?, '0'
//                                )", array($model->getUsername(), $model->getPassword()))->execute();
    }
}