<?php

namespace FTS\Routers;


class DefaultRouter implements IRouter
{

    public function getURI()
    {
        return strtolower(substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1));
    }
}