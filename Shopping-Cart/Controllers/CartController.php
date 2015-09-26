<?php

namespace Controllers;


use FTS\BaseController;
use FTS\Normalizer;
use Models\ViewModels\CartController\CartProductViewModel;
use Models\ViewModels\CartController\IndexViewModel;

class CartController extends BaseController
{
    /**
     * @Authorize
     */
    public function index()
    {
        $cart = $this->session->cart;
        $products = array();
        $totalPrice = 0;
        $money = 0;
        if ($cart) {
            foreach ($cart as $itemId) {
                $this->db->prepare("SELECT
                            p.id, p.name, p.price
                            FROM products p
                            JOIN products_categories pc
                            ON p.id = pc.productId
                            JOIN categories c
                            ON pc.categoryId = c.id
                            WHERE p.id = ?",
                    array($itemId));
                $response = $this->db->execute()->fetchRowAssoc();
                $price = Normalizer::normalize($response['price'], 'noescape|double');
                $product = new CartProductViewModel(
                    Normalizer::normalize($response['id'], 'noescape|int'),
                    $response['name'],
                    $price);
                $products[] = $product;
                $totalPrice += $price;
            }

            $this->db->prepare("SELECT
                            Cash
                            FROM users
                            WHERE id = ? AND username = ?",
                array($this->session->_login, $this->session->_username));
            $response = $this->db->execute()->fetchRowAssoc();
            $money = Normalizer::normalize($response['Cash'], 'noescape|double');
        }

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', new IndexViewModel($products, $totalPrice, $money));
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.cart');
    }

    /**
     * @Authorize
     * @Get
     * @Route("cart/add/{id:int}")
     */
    public function add()
    {
        if (!$this->session->cart) {
            $this->session->cart = array();
        }

        $cart = $this->session->cart;
        $cart[] = $this->input->get(2);
        $this->session->cart = $cart;

        $this->redirect('/');
    }

    /**
     * @Authorize
     * @Delete
     * @Route("cart/remove/{id:int}")
     */
    public function remove()
    {
        if (!$this->session->cart) {
            throw new \Exception("Cart is empty!", 500);
        }

        $id = $this->input->get(2);
        $cart = $this->session->cart;
        foreach ($cart as $k => $itemId) {
            if ($itemId == $id) {
                var_dump($k);
                unset($cart[$k]);
                break;
            }
        }

        $this->session->cart = $cart;

        $this->redirect('/cart');
    }

    /**
     * @Authorize
     * @Post
     * @Route("cart/checkout")
     */
    public function checkout(){

    }
}