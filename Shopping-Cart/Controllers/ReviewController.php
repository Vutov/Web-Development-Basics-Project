<?php

namespace Controllers;


use FTS\BaseController;
use FTS\Normalizer;
use Models\BindingModels\ReviewBindingModel;

class ReviewController extends BaseController
{

    /**
     * @Post
     * @Authorize
     * @Route("Review/add/{id:int}")
     * @param ReviewBindingModel $model
     * @throws \Exception
     */
    public function add(ReviewBindingModel $model)
    {
        $message = Normalizer::normalize($model->getMessage(), 'noescape|trim');
        $productId = $this->input->get(2);
        $this->db->prepare("SELECT id
                            FROM users
                            WHERE id = ? AND username = ?",
            array($this->session->_login, $this->session->_username));
        $response = $this->db->execute()->fetchRowAssoc();
        $id = $response['id'];
        if ($id) {
            $this->db->prepare("SELECT name
                            FROM products
                            WHERE id = ?",
                array($productId));
            $response = $this->db->execute()->fetchRowAssoc();
            if (!$response) {
                throw new \Exception("No product with id '$productId'", 404);
            }

            $this->db->prepare("INSERT
                            INTO reviews
                            (message, userId, productId)
                            VALUES (?, ?, ?)",
                array($message, $id, $productId)
            )->execute();
        }

        $this->redirect("/product/$productId/show");
    }
}