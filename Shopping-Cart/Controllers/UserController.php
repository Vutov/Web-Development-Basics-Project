<?php

namespace Controllers;


use FTS\BaseController;
use Models\BindingModels\LoginBindingModel;
use Models\BindingModels\RegisterBindingModel;
use Models\ViewModels\UserController\ProfileViewModel;

class UserController extends BaseController
{
    /**
     * @NotLogged
     * @param LoginBindingModel $model
     * @throws \Exception
     */
    public function login(LoginBindingModel $model)
    {
        $this->db->prepare("SELECT id, username
                                FROM users
                                WHERE username = ? AND password = ?",
            array($model->getUsername(), $model->getPassword()));
        $response = $this->db->execute()->fetchRowAssoc();
        $id = $response['id'];
        $username = $response['username'];
        $this->session->_login = $id;
        $this->session->_username = $model->getUsername();
        $this->session->escapedUsername = $username;
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
     * @NotLogged
     * @param RegisterBindingModel $model
     * @throws \Exception
     */
    public function register(RegisterBindingModel $model)
    {
        // Check for already registered with the same name
        $this->db->prepare("SELECT id
                                FROM users
                                WHERE username = ?",
            array($model->getUsername()));
        $response = $this->db->execute()->fetchRowAssoc();
        $id = $response['id'];
        if ($id !== null) {
            $username = $model->getUsername();
            throw new \Exception("Username '$username' already taken!", 400);
        }

        $this->db->prepare("INSERT
                            INTO users
                            (username, password, cash)
                            VALUES (?, ?, ?)",
            array(
                $model->getUsername(),
                $model->getPassword(),
                $this->config->cart['initialCash']
            )
        )->execute();

        $loginBindingModel = new LoginBindingModel(array('username' => $model->getUsername(), 'password' => $model->getPassword()));
        // Work around to avoid double crypting passwords.
        $loginBindingModel->afterRegisterPasswordPass($model->getPassword());
        $this->login($loginBindingModel);
    }

    /**
     * @Get
     * @Route("user/{name:string}/profile")
     */
    public function profile()
    {
        $username = $this->input->get(1);
        $this->db->prepare("SELECT id, isAdmin
                                FROM users
                                WHERE username = ?",
            array($username));
        $response = $this->db->execute()->fetchRowAssoc();
        if ($response === false) {
            throw new \Exception("No user found with name '$username'", 404);
        }

        $isAdmin = $response['isAdmin'];

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', new ProfileViewModel($username, $isAdmin));
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.userProfile');
    }

    /**
     * @Authorize
     * @Put
     * @Route("user/changePass")
     */
    public function changePass(){
        echo "ok";
    }
}