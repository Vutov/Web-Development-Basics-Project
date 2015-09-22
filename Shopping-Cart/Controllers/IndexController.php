<?php

namespace Controllers;

use FTS\App;
use FTS\BaseController;
use Models\BindingModels\LoginBindingModel;
use Models\BindingModels\RegisterBindingModel;
use Models\ViewModels\IndexController\CreateViewModel;

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
        $this->view->display(new CreateViewModel('asd'));
    }

    /**
     * @Route("test/delete")
     * @Delete
     */
    public function delete()
    {
        echo "delete";
    }

    /**
     * @param LoginBindingModel $model
     * @throws \Exception
     */
    public function login(LoginBindingModel $model)
    {
        $this->checkForLogged();

        $this->db->prepare("SELECT id
                                FROM users
                                WHERE username = ? AND password = ?",
            array($model->getUsername(), $model->getPassword()));
        $response = $this->db->execute()->fetchRowAssoc();
        $id = $response['id'];
        $this->session->_login = $id;
        $this->session->_username = $model->getUsername();
        $this->redirect('/');
    }

    /**
     * @Authorize error:("You are not logged in!")
     * @throws \Exception
     */
    public function logout()
    {
        $this->session->destroySession();
        $this->redirect('/');
    }

    /**
     * TODO check for existing user id DB
     * @param RegisterBindingModel $model
     */
    public function register(RegisterBindingModel $model)
    {
        $this->checkForLogged();

        $this->db->prepare("INSERT
                            INTO users
                            (username, password, cash)
                            VALUES (?, ?, ?)",
            array(
                $model->getUsername(),
                $model->getPassword(),
                App::getInstance()->getConfig()->cart['initialCash']
            )
        )->execute();

        $loginBindingModel = new LoginBindingModel(array('username' => $model->getUsername(), 'password' => $model->getPassword()));
        // Work around to avoid double crypting passwords.
        $loginBindingModel->afterRegisterPasswordPass($model->getPassword());
        $this->login($loginBindingModel);
    }
}