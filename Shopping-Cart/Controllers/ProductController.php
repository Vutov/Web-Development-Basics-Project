<?php

namespace Controllers;


use FTS\BaseController;
use FTS\Normalizer;
use Models\ViewModels\ProductController\IndexViewModel;
use Models\ViewModels\ProductController\ProductViewModel;

class ProductController extends BaseController
{

    /**
     * @Get
     * @Route("Products/{start:int}/{end:int}")
     */
    public function index()
    {
        $skip = $this->input->get(1);
        $take = $this->input->get(2);
        $this->db->prepare("SELECT
                            p.id, p.name, p.description, p.price, p.quantity, c.name as category
                            FROM products p
                            JOIN products_categories pc
                            ON p.id = pc.productId
                            JOIN categories c
                            ON pc.categoryId = c.id
                            WHERE quantity > 0
                            ORDER BY p.id
                            LIMIT {$take}
                            OFFSET {$skip}");
        $response = $this->db->execute()->fetchAllAssoc();
        $products = array();
        foreach ($response as $p) {
            $product = new ProductViewModel(
                Normalizer::normalize($p['id'], 'noescape|int'),
                $p['name'],
                $p['description'],
                Normalizer::normalize($p['price'], 'noescape|double'),
                Normalizer::normalize($p['quantity'], 'noescape|int'),
                $p['category']);
            $products[] = $product;
        }

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', new IndexViewModel($products, $skip, $take));
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.products');
    }

    /**
     * @Get
     * @Route("product/{id:int}/show")
     */
    public function product()
    {
        $id = $this->input->get(1);
        $this->db->prepare("SELECT
                            p.id, p.name, p.description, p.price, p.quantity, c.name as category
                            FROM products p
                            JOIN products_categories pc
                            ON p.id = pc.productId
                            JOIN categories c
                            ON pc.categoryId = c.id
                            WHERE quantity > 0 AND p.id = ?",
            array($id));
        $response = $this->db->execute()->fetchRowAssoc();
        if (!$response) {
            throw new \Exception("No product with id '$id'!", 404);
        }

        $product = new ProductViewModel(
            Normalizer::normalize($response['id'], 'noescape|int'),
            $response['name'],
            $response['description'],
            Normalizer::normalize($response['price'], 'noescape|double'),
            Normalizer::normalize($response['quantity'], 'noescape|int'),
            $response['category']
        );


        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $product);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.product');
    }
}