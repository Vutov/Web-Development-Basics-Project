<?php

namespace Controllers;


use FTS\App;
use FTS\BaseController;
use FTS\Normalizer;
use Models\BindingModels\ChangeProductBindingModel;
use Models\BindingModels\NameBindingModel;
use Models\BindingModels\SellProductBindingModel;
use Models\ViewModels\ProductController\EditViewModel;
use Models\ViewModels\ProductController\IndexViewModel;
use Models\ViewModels\ProductController\ProductMessage;
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
        $take = $this->input->get(2) - $skip;
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
        $this->view->appendToLayout('body', new IndexViewModel($products, $skip, $take + $skip));
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
                            WHERE p.id = ?",
            array($id));
        $response = $this->db->execute()->fetchRowAssoc();
        if (!$response) {
            throw new \Exception("No product with id '$id'!", 404);
        }

        $quantity = Normalizer::normalize($response['quantity'], 'noescape|int');
        if ($quantity <= 0) {
            if (!App::getInstance()->isAdmin() && !App::getInstance()->isEditor()) {
                throw new \Exception("No product with id '$id'!", 404);
            }
        }

        $this->db->prepare("SELECT
                            u.username, u.isAdmin, u.isEditor, u.isModerator, r.message
                            FROM reviews r
                            JOIN products p
                            ON r.productId = p.id
                            JOIN users u
                            ON r.userId = u.id
                            WHERE p.id = ?",
            array($id));
        $reviews = $this->db->execute()->fetchAllAssoc();
        $givenReviews = array();
        foreach ($reviews as $r) {
            $givenReviews[] = new ProductMessage(
                $r['username'],
                $r['message'],
                Normalizer::normalize($r['isAdmin'], 'noescape|bool'),
                Normalizer::normalize($r['isEditor'], 'noescape|bool'),
                Normalizer::normalize($r['isModerator'], 'noescape|bool')
            );
        }

        $product = new ProductViewModel(
            Normalizer::normalize($response['id'], 'noescape|int'),
            $response['name'],
            $response['description'],
            Normalizer::normalize($response['price'], 'noescape|double'),
            $quantity,
            $response['category'],
            $givenReviews
        );


        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $product);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.product');
    }

    /**
     * @Route("products/sell")
     * @Authorize
     */
    public function sell()
    {
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'sell');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.sellProduct');
    }

    /**
     * @Route("product/add")
     * @Post
     * @Authorize
     * @param SellProductBindingModel $model
     * @throws \Exception
     */
    public function add(SellProductBindingModel $model)
    {
        $this->db->prepare("SELECT
                            id, name
                            FROM categories
                            WHERE name LIKE ?",
            array($model->getCategory()));
        $response = $this->db->execute()->fetchRowAssoc();
        $categoryId = Normalizer::normalize($response['id'], 'noescape|int');
        if (!$response) {
            $name = $model->getCategory();
            throw new \Exception("No category '$name'!", 404);
        }

        $this->db->prepare("INSERT
                            INTO products
                            (name, description, price, quantity)
                            VALUES (?, ?, ?, ?)",
            array($model->getName(), $model->getDescription(), $model->getPrice(), 1));
        $this->db->execute();

        $this->db->prepare("SELECT
                            id
                            FROM products
                            WHERE name = ? AND description = ?",
            array($model->getName(), $model->getDescription()));
        $response = $this->db->execute()->fetchRowAssoc();
        $productId = Normalizer::normalize($response['id'], 'noescape|int');

        $this->db->prepare("INSERT
                            INTO products_categories
                            (productId, categoryId)
                            VALUES (?, ?)",
            array($productId, $categoryId));
        $this->db->execute();

        $this->redirect("/product/$productId/show");
    }

    /**
     * @Post
     * @Route("products/find")
     * @param NameBindingModel $model
     */
    public function find(NameBindingModel $model)
    {
        $this->db->prepare("SELECT
                            id
                            FROM products
                            WHERE name LIKE ?",
            array($model->getName()));
        $response = $this->db->execute()->fetchRowAssoc();
        if ($response) {
            $productId = Normalizer::normalize($response['id'], 'noescape|int');
            $this->redirect("/product/$productId/show");
        } else {
            $this->redirect('/editor');
        }
    }

    /**
     * @Get
     * @Role("Editor")
     * @Route("product/{id:int}/edit")
     */
    public function edit()
    {
        $id = $this->input->get(1);
        $this->db->prepare("SELECT
                            p.id, p.name, p.description, p.price, p.quantity, c.name as category
                            FROM products p
                            JOIN products_categories pc
                            ON p.id = pc.productId
                            JOIN categories c
                            ON pc.categoryId = c.id
                            WHERE p.id = ?",
            array($id));
        $response = $this->db->execute()->fetchRowAssoc();
        if (!$response) {
            throw new \Exception("No product with id '$id'!", 404);
        }

        $product = new EditViewModel(
            Normalizer::normalize($response['id'], 'noescape|int'),
            $response['name'],
            $response['description'],
            Normalizer::normalize($response['price'], 'noescape|double'),
            $quantity = Normalizer::normalize($response['quantity'], 'noescape|int'),
            $response['category']);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $product);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.product');
    }

    /**
     * @Put
     * @Role("Editor")
     * @Route("product/change/{id:int}")
     * @param ChangeProductBindingModel $model
     * @throws \Exception
     */
    public function change(ChangeProductBindingModel $model)
    {
        $this->db->prepare("SELECT
                            id
                            FROM categories
                            WHERE name LIKE ?",
            array($model->getCategory()));
        $response = $this->db->execute()->fetchRowAssoc();
        $categoryId = Normalizer::normalize($response['id'], 'noescape|int');
        if (!$response) {
            $name = $model->getCategory();
            throw new \Exception("No category '$name'!", 404);
        }

        $id = $this->input->get(2);

        $this->db->prepare("UPDATE products_categories SET categoryId = ? WHERE productId =?", array($categoryId, $id))->execute();
        $this->db->prepare("UPDATE products
                                SET name = ?, description = ?, price = ?, quantity = ?
                                WHERE id = ?",
            array($model->getName(), $model->getDescription(), $model->getPrice(), $model->getQuantity(), $id));
        $this->db->execute();
        $this->redirect("/product/$id/show");
    }

    /**
     * @Delete
     * @Role("Editor")
     * @Route("product/{id:int}/delete")
     * @throws \Exception
     */
    public function delete()
    {
        $id = $this->input->get(1);
        $this->db->prepare("DELETE FROM products_categories WHERE productId =?", array($id))->execute();
        $this->db->prepare("DELETE FROM products
                                WHERE id = ?",
            array($id));
        $this->db->execute();
        $this->redirect("/");
    }
}