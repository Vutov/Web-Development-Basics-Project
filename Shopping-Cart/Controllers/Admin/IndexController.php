<?php

namespace Controllers\Admin;

use FTS\BaseController;
use Models\ViewModels\Admin\IndexController\CreateViewModel;
use Models\ViewModels\Admin\IndexController\IndexViewModel;


class IndexController extends BaseController
{
    /**
     * @Admin
     * @throws \Exception
     */
    public function index()
    {
        $this->db->prepare("SELECT username
                                FROM users
                                WHERE isAdmin = 1");
        $response = $this->db->execute()->fetchAllAssoc();
        $admins = array();
        foreach ($response as $admin) {
            $admins[] = $admin['username'];
        }

        $this->view->appendToLayout('body', new IndexViewModel($admins));
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
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