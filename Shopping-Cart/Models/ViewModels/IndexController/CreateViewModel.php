<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/22/15
 * Time: 9:14 PM
 */

namespace Models\ViewModels\IndexController;


class CreateViewModel
{
    private $someShit;

    public function __construct($someShit)
    {
        $this->someShit = $someShit;
    }

    /**
     * @return mixed
     */
    public function getSomeShit()
    {
        return $this->someShit;
    }
}