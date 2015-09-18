<?php

namespace Controllers\Admin;

use FTS\Validator;
use FTS\View;

class IndexController
{
    public function index()
    {
        $model = 'some shit';
        $validator = new Validator();
        $validModel = $validator->setRule('minlength', $model, 10, 'invalid lenght')->validate();
        if (!$validModel) {
            $model = $validator->getErrors()[0];
        }

        $view = View::getInstance();
        $view->appendToLayout('body', 'Admin.index');
        $view->appendToLayout('header', 'header');
        $view->appendToLayout('footer', 'footer');
        $view->display('Layouts.Admin.home', array('model' => $model, 0 => 1, 'Admin' => "no"));
    }

    public function create()
    {
        echo 'Admin create in Index file';
    }
}