<?php

namespace Models\ViewModels\CartController;


class IndexViewModel
{
    private $products;
    private $totalSum;

    public function __construct(array $products, $totalSum)
    {
        $this->products = $products;
        $this->totalSum = $totalSum;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function getTotalSum()
    {
        return $this->totalSum;
    }
}