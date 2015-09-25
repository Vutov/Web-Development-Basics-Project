<?php

namespace Controllers;


use FTS\BaseController;
use FTS\Normalizer;
use Models\ViewModels\CategoryController\ShowViewModel;
use Models\ViewModels\ProductController\ProductViewModel;

class CategoryController extends BaseController {

    /**
     * @Get
     * @Route("Categories/{category:string}/{start:int}/{end:int}")
     */
    public function show(){
        $category = $this->input->getForDb(1);
        $skip = $this->input->get(2);
        $take = $this->input->get(3);
        $this->db->prepare("SELECT
                            p.name, p.description, p.price, p.quantity, c.name as category
                            FROM products p
                            JOIN products_categories pc
                            ON p.id = pc.productId
                            JOIN categories c
                            ON pc.categoryId = c.id
                            WHERE quantity > 0 AND c.name LIKE ?
                            ORDER BY p.id
                            LIMIT {$take}
                            OFFSET {$skip}", array($category));
        $response = $this->db->execute()->fetchAllAssoc();
        $products = array();
        foreach ($response as $p) {
            $product = new ProductViewModel(
                $p['name'],
                $p['description'],
                Normalizer::normalize($p['price'], 'noescape|double'),
                Normalizer::normalize($p['quantity'], 'noescape|int'),
                $p['category']);
            $products[] = $product;
        }

        // Escaped one
        $category = $this->input->get(1);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', new ShowViewModel($products, $skip, $take, $category));
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.products');
    }

    public function index(){

    }

}