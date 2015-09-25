<?php

namespace Controllers;


class CategoryController {

    /**
     * @Get
     * @Route("Categories/{category:string}/{start:int}/{end:int}")
     */
    public function showProductsByCategory(){
        echo 'product by category';
    }

}