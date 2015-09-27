<?php

namespace Controllers\Editor;


use FTS\BaseController;
use FTS\Normalizer;
use Models\BindingModels\NameBindingModel;
use Models\BindingModels\PromotionBindingModel;
use Models\ViewModels\Editor\PromotionController\AllViewModel;
use Models\ViewModels\Editor\PromotionController\PromotionViewModel;

class PromotionController extends BaseController
{

    /**
     * @Post
     * @Route("editor/promotion/add")
     * @Role("Editor")
     * @param PromotionBindingModel $model
     * @throws \Exception
     */
    public function add(PromotionBindingModel $model)
    {
        $this->db->prepare("SELECT
                            p.id
                            FROM products p
                            WHERE p.name LIKE ?",
            array($model->getName()));
        $response = $this->db->execute()->fetchRowAssoc();
        if (!$response) {
            $name = $model->getName();
            throw new \Exception("No product with name '$name'!", 400);
        }
        $id = Normalizer::normalize($response['id'], 'noescape|int');

        $this->db->prepare("INSERT
                            INTO promotions
                            (name, productId, percentage, endDate)
                            VALUES (?, ?, ?, ?)",
            array(
                $model->getName(),
                $id,
                $model->getPercentage(),
                $model->getDate()
            )
        )->execute();

        $this->redirect('/editor');
    }

    /**
     * @Delete
     * @Route("editor/promotion/remove")
     * @Role("Editor")
     * @param NameBindingModel $model
     */
    public function remove(NameBindingModel $model)
    {
        $this->db->prepare("DELETE
                            FROM promotions
                            WHERE name LIKE ?",
            array(
                $model->getName()
            )
        )->execute();

        $this->redirect('/editor');
    }

    /**
     * @Get
     * @Route("editor/promotions/all")
     * @Role("Editor")
     */
    public function all()
    {
        $response = $this->db->prepare("SELECT pr.name, p.name as product, pr.percentage, pr.endDate
                            FROM promotions pr
                            JOIN products p
                            ON pr.productId = p.id")
            ->execute()->fetchAllAssoc();

        $promotions = array();
        foreach ($response as $p) {
            $promotions[] = new PromotionViewModel(
                $p['name'],
                $p['product'],
                Normalizer::normalize($p['percentage'], 'noescape|double'),
                $p['endDate']
            );
        }

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', new AllViewModel($promotions));
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.Editor.home');

    }
}