<?php

namespace Controllers\Editor;


use FTS\BaseController;
use Models\BindingModels\NameBindingModel;
use Models\BindingModels\RenameBindingModel;

class CategoryController extends BaseController
{

    /**
     * @Role("Editor")
     * @Post
     * @param NameBindingModel $model
     */
    public function add(NameBindingModel $model)
    {
        $this->db->prepare("INSERT
                            INTO categories
                            (name)
                            VALUES (?)",
            array($model->getName())
        )->execute();

        $this->redirect('/categories');
    }

    /**
     * @Role("Editor")
     * @Delete
     * @param NameBindingModel $model
     * @throws \Exception
     */
    public function remove(NameBindingModel $model)
    {
        $response = $this->db->prepare("SELECT id
                            FROM categories
                            WHERE name LIKE ?",
            array($model->getName())
        )->execute()->fetchRowAssoc();
        if (!$response) {
            throw new \Exception("No category '" . $model->getName() . " ' found!", 400);
        }
        $id = $response['id'];

        $response = $this->db->prepare("SELECT p.id
                                        FROM categories c
                                        JOIN products_categories pc
                                        ON c.id = pc.categoryId
                                        JOIN products p
                                        ON p.id = pc.productId
                                        WHERE categoryId = ?",
            array($id))
            ->execute()->fetchRowAssoc();
        if ($response) {
            throw new \Exception("Category is not empty! Move all products first!", 400);
        }

        $this->db->prepare("DELETE FROM
                            categories
                            WHERE name LIKE ?",
            array($model->getName())
        )->execute();

        $this->redirect('/categories');
    }

    /**
     * @Role("Editor")
     * @Put
     * @param RenameBindingModel $model
     */
    public function rename(RenameBindingModel $model)
    {
        $this->db->prepare("UPDATE
                            categories
                            SET name = ?
                            WHERE name LIKE ?",
            array($model->getNewName(), $model->getOldName())
        )->execute();

        $this->redirect('/categories');
    }
}