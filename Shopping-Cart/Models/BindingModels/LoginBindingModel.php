<?php

namespace Models\BindingModels;

//TODO Add @ for validation
class LoginBindingModel
{
    private $username;
    private $password;

    function __construct(array $params)
    {
        $this->password = $params['password'];
        $this->username = $params['username'];
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
    public function setUsername($username)
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
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}