<?php

namespace Models\ViewModels\CategoryController;


class IndexViewModel
{

    private $categories;

    public function __construct(array $categories)
    {
        $this->categories = $categories;
    }

    public function getCategories()
    {
        return $this->categories;
    }
}