<?php

namespace Controllers\Editor;


use FTS\BaseController;
use Models\BindingModels\NameBindingModel;

class CategoryController extends BaseController {

    /**
     * @Role("Editor")
     * @Post
     * @param NameBindingModel $model
     */
    public function add(NameBindingModel $model){

    }
}