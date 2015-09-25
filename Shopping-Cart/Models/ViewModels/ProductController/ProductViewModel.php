<?php

namespace Models\ViewModels\ProductController;


class ProductViewModel
{

    private $name;
    private $description;
    private $price;
    private $quantity;
    private $category;

    public function __construct($name, $description, $price, $quantity, $category)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->category = $category;
    }

    public function getName()
    {
        return $this->name;
    }

    function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }


    public function getCategory()
    {
        return $this->category;
    }
}