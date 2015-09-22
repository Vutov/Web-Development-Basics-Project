<?php

namespace Controllers\Admin;

use FTS\BaseController;
use Models\ViewModels\Admin\IndexController\CreateViewModel;
use Models\ViewModels\Admin\IndexController\IndexViewModel;


class IndexController extends BaseController
{
    /**
     * @Admin
     * @Get
     * @Route("custom/{id:int}/index")
     * @throws \Exception
     */
    public function index()
    {
        $model = 'some shit';
        $validModel = $this->validator->setRule('minlength', $model, 10, 'invalid lenght')->validate();
        if (!$validModel) {
            $model = $this->validator->getErrors()[0];
        }

        $this->view->appendToLayout('body', new IndexViewModel('TestAdmin', $model, 'no'));
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.Admin.home');
    }

    /**
     * @Get
     * @Route("Custom/{name:string}/Create")
     * @Role("Editor")
     * @throws \Exception
     */
    public function create()
    {
        $this->view->appendToLayout('body', new CreateViewModel('TestAdmin'));
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.Admin.home');
    }
}