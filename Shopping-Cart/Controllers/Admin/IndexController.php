<?php

namespace Controllers\Admin;

use FTS\View;

class IndexController
{
    public function index()
    {
        $view = View::getInstance();
        $view->appendToLayout('body', 'Admin.index');
        $view->appendToLayout('header', 'header');
        $view->appendToLayout('footer', 'footer');
        $view->display('Layouts.Admin.home', array('a', 'b', 'c'));
    }

    public function create()
    {
        echo 'Admin create in Index file';
    }
}