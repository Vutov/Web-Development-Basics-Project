<?php

namespace Controllers;

use FTS\InputData;

class IndexController
{
    public function index()
    {
        echo 'Index file';
    }

    public function create()
    {
        var_dump(InputData::getInstance()->get(0));
        echo 'Create in Index file';
    }
}