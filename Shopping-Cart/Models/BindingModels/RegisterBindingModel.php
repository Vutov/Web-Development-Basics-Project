<?php

namespace Models\BindingModels;


class RegisterBindingModel
{

    private $username;
    private $password;
    private $confirm;

    function __construct(array $params)
    {
        $this->setPassword($params['password']);
        $this->setUsername($params['username']);
        $this->setConfirm($params['confirm']);
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    private function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    private function setPassword($password)
    {
        //TODO find better hashing function.
        $this->password = crypt($password, PASSWORD_DEFAULT);
    }


    public function getConfirm(){
        return $this->confirm;
    }

    private function setConfirm($password)
    {
        //TODO find better hashing function.
        $this->confirm = crypt($password, PASSWORD_DEFAULT);
    }
}