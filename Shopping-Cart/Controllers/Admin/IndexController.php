<?php

namespace Controllers\Admin;

use FTS\View;

class IndexController
{
    public function index()
    {
        $view = View::getInstance();
        $view->display('Admin.index', array(1, 2, 3));

    }

    public function create()
    {
        echo 'Admin create in Index file';
    }
}