<?php

namespace Controllers;

use FTS\BaseController;
use Models\ViewModels\IndexController\IndexViewModel;

class IndexController extends BaseController
{
    public function index()
    {
        $this->view->display(new IndexViewModel('some shit'));
    }

    public function create()
    {
        var_dump($this->input->get(0));
        echo 'Create in Index file';
    }
}