<?php

namespace Controllers\Admin;

use FTS\BaseController;
use Models\BindingModels\RightsBindingModel;
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
     * @Admin
     * @throws \Exception
     */
    public function edit()
    {
        $this->view->appendToLayout('body', 'Admin.IndexController.edit');
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.Admin.home');
    }

    /**
     * @Admin
     * @param RightsBindingModel $model
     */
    public function add(RightsBindingModel $model)
    {
        $username = $model->getUsername();
        $right = ucfirst(strtolower($model->getRightName()));
        $this->db->prepare("UPDATE users
                            SET is{$right} = 1
                            WHERE username = ?",
            array($username));
        $this->db->execute();

        $this->redirect('/admin');
    }

    /**
     * @Admin
     * @param RightsBindingModel $model
     */
    public function remove(RightsBindingModel $model)
    {
        $username = $model->getUsername();
        $right = ucfirst(strtolower($model->getRightName()));
        $this->db->prepare("UPDATE users
                            SET is{$right} = 0
                            WHERE username = ?",
            array($username));
        $this->db->execute();

        $this->redirect('/admin');
    }
}