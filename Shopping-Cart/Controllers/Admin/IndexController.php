<?php

namespace Controllers\Admin;

use FTS\BaseController;
use FTS\Validator;
use FTS\View;

class IndexController extends BaseController
{
    public function index()
    {
        $model = 'some shit';
        $validModel = $this->validator->setRule('minlength', $model, 10, 'invalid lenght')->validate();
        if (!$validModel) {
            $model = $this->validator->getErrors()[0];
        }

        $this->view->appendToLayout('body', 'Admin.index');
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->display('Layouts.Admin.home', array('model' => $model, 0 => 1, 'Admin' => "no"));
    }

    public function create()
    {
        echo 'Admin create in Index file';
    }
}