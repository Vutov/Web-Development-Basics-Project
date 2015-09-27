<?php

namespace Models\ViewModels\Editor\PromotionController;


class AllViewModel
{
    private $promotions;

    function __construct($promotions)
    {
        $this->promotions = $promotions;
    }

    /**
     * @return mixed
     */
    public function getPromotions()
    {
        return $this->promotions;
    }
}