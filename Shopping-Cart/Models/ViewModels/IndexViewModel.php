<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/20/15
 * Time: 10:32 PM
 */

namespace Models\ViewModels;


class IndexViewModel {
    private $someShit;

    public function __construct($someShit){
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