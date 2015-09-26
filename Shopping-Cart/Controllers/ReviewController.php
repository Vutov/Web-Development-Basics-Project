<?php

namespace Controllers;


use Models\BindingModels\ReviewBindingModel;

class ReviewController {

    /**
     * @Post
     * @Authorize
     * @Route("Review/add/{id:int}")
     * @param ReviewBindingModel $model
     */
    public function add(ReviewBindingModel $model){
        var_dump($model);
        die;
    }
}