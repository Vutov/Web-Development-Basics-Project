<?php

namespace Models\ViewModels\ProductController;


class ProductMessage {
    private $username;
    private $message;
    private $isAdmin;
    private $isEditor;

    function __construct($username, $message, $isAdmin, $isEditor)
    {
        $this->username = $username;
        $this->message = $message;
        $this->isAdmin = $isAdmin;
        $this->isEditor = $isEditor;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @return mixed
     */
    public function getIsEditor()
    {
        return $this->isEditor;
    }
}