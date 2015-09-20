<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/20/15
 * Time: 11:24 PM
 */

namespace Models\ViewModels\Admin\IndexController;


class AdminCreateViewModel {
    private $someShit;

    function __construct($someShit)
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