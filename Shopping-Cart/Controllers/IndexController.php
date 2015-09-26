<?php

namespace Controllers;

use FTS\BaseController;
use Models\ViewModels\IndexController\CreateViewModel;

class IndexController extends BaseController
{
    public function index()
    {
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'home');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.home');
    }

    /**
     * @Route("test")
     */
    public function create()
    {
        $this->view->display(new CreateViewModel('asd'));
    }

    /**
     * @Route("test/delete")
     * @Delete
     */
    public function delete()
    {
        echo "delete";
    }

    /**
     * @Get
     * @Route("Home/Login")
     * @throws \Exception
     */
    public function login(){
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'login');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.login');
    }
}