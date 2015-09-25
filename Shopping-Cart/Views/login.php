<div class="row row-eq-height">
    <div class="panel panel-primary  col-sm-5">
        <h1 class="text-center">Login</h1>
        <?php
        \FTS\FormViewHelper::init()
            ->initForm('/user/login', ['class' => 'form-group'], 'post')
            ->initLabel()->setValue("Username")->setAttribute('for', 'username')->create()
            ->initTextBox()->setName('username')->setAttribute('id', 'username')->setAttribute('class', 'form-control input-md')->create()
            ->initLabel()->setValue("Password")->setAttribute('for', 'password')->create()
            ->initPasswordBox()->setName('password')->setAttribute('id', 'password')->setAttribute('class', 'form-control input-md')->create()
            ->initSubmit()->setAttribute('value', 'Login')->setAttribute('class', 'btn btn-primary btn-lg col-sm-4 col-sm-offset-4')->create()
            ->render(); ?>
    </div>
    <div class="panel panel-primary col-sm-5 col-sm-offset-2">
        <h1 class="text-center">Register</h1>
        <?php
        \FTS\FormViewHelper::init()
            ->initForm('/user/register', ['class' => 'form-group'], 'post')
            ->initLabel()->setValue("Username")->setAttribute('for', 'username')->create()
            ->initTextBox()->setName('username')->setAttribute('id', 'username')->setAttribute('class', 'form-control input-md')->create()
            ->initLabel()->setValue("Password")->setAttribute('for', 'password')->create()
            ->initPasswordBox()->setName('password')->setAttribute('id', 'password')->setAttribute('class', 'form-control input-md')->create()
            ->initLabel()->setValue("Confirm Password")->setAttribute('for', 'confPassword')->create()
            ->initPasswordBox()->setName('confirm')->setAttribute('id', 'confPassword')->setAttribute('class', 'form-control input-md')->create()
            ->initSubmit()->setAttribute('value', 'Register')->setAttribute('class', 'btn btn-primary btn-lg col-sm-4 col-sm-offset-4')->create()
            ->render(true);
        ?>
    </div>
</div>
