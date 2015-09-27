<div class="panel">
    <h1 class="text-center">Editor panel</h1>
    <br/>
    <div class="row">
        <h2 class="col-sm-offset-1">Categories edit</h2>
        <?php
        \FTS\FormViewHelper::init()
            ->initForm('/editor/category/add', ['class' => 'form-group col-sm-4'], 'post')
            ->initLabel()->setValue("Category name")->setAttribute('for', 'name')->create()
            ->initTextBox()->setName('name')->setAttribute('id', 'name')->setAttribute('class', 'form-control input-md')->create()
            ->initSubmit()->setAttribute('value', 'Add category')->setAttribute('class', 'btn btn-primary col-sm-4 col-sm-offset-4')->create()
            ->render();
        \FTS\FormViewHelper::init()
            ->initForm('/editor/category/remove', ['class' => 'form-group col-sm-4'], 'delete')
            ->initLabel()->setValue("Category name")->setAttribute('for', 'name')->create()
            ->initTextBox()->setName('name')->setAttribute('id', 'name')->setAttribute('class', 'form-control input-md')->create()
            ->initSubmit()->setAttribute('value', 'Remove category')->setAttribute('class', 'btn btn-primary col-sm-4 col-sm-offset-4')->create()
            ->render(true);
        \FTS\FormViewHelper::init()
            ->initForm('/editor/category/remove', ['class' => 'form-group col-sm-4'], 'put')
            ->initLabel()->setValue("Old category name")->setAttribute('for', 'oldName')->create()
            ->initTextBox()->setName('oldName')->setAttribute('id', 'oldName')->setAttribute('class', 'form-control input-md')->create()
            ->initLabel()->setValue("New category name")->setAttribute('for', 'newName')->create()
            ->initTextBox()->setName('newName')->setAttribute('id', 'newName')->setAttribute('class', 'form-control input-md')->create()
            ->initSubmit()->setAttribute('value', 'Rename category')->setAttribute('class', 'btn btn-primary col-sm-4 col-sm-offset-4')->create()
            ->render(true);
        ?>
    </div>
    <hr/>
    <div class="row">
        <h2 class="col-sm-offset-1">Products edit</h2>
        <?php
        \FTS\FormViewHelper::init()
            ->initForm('/products/find', ['class' => 'form-group col-sm-4'], 'post')
            ->initLabel()->setValue("Product name")->setAttribute('for', 'name')->create()
            ->initTextBox()->setName('name')->setAttribute('id', 'name')->setAttribute('class', 'form-control input-md')->create()
            ->initSubmit()->setAttribute('value', 'Edit product')->setAttribute('class', 'btn btn-primary col-sm-4 col-sm-offset-4')->create()
            ->render(true);
        ?>
    </div>
</div>