<?php

namespace FTS\Routers;


class DefaultRouter implements IRouter
{
    public function getURI()
    {
        //var_dump(substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1));
        return strtolower(ltrim ($_SERVER['REQUEST_URI'], '/'));
    }

    public function getPost()
    {
        return $_POST;
    }

    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}