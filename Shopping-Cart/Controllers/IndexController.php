<?php

namespace Controllers;

use FTS\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        echo 'Index file';
    }

    public function create()
    {
        var_dump($this->input->get(0));
        echo 'Create in Index file';
    }
}