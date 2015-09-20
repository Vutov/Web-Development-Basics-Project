<?php

namespace Models\ViewModels\Admin;


class AdminIndexViewModel {
    private $name;
    private $password;
    private $admin;

    public function __construct($name, $password, $admin){
        $this->name =$name;
        $this->password = $password;
        $this->admin = $admin;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }
}