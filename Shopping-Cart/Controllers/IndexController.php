<?php

namespace Controllers;

use FTS\InputData;

class IndexController
{
    public function index()
    {
        var_dump(InputData::getInstance()->get(0));
        echo 'Index file';
    }

    public function create()
    {
        echo 'Create in Index file';
    }
}