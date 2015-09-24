<?php
\FTS\FormViewHelper::init()
    ->initForm('/user/login')
    ->initLabel()->setValue("Username")->setAttribute('for', 'username')->create()
    ->initTextBox()->setName('username')->setAttribute('id', 'username')->create()
    ->initLabel()->setValue("Password")->setAttribute('for', 'password')->create()
    ->initPasswordBox()->setName('password')->setAttribute('id', 'password')->create()
    ->initSubmit()->setAttribute('value', 'Login')->create()
    ->render();
\FTS\FormViewHelper::init()
    ->initForm('/user/register')
    ->initLabel()->setValue("Username")->setAttribute('for', 'username')->create()
    ->initTextBox()->setName('username')->setAttribute('id', 'username')->create()
    ->initLabel()->setValue("Password")->setAttribute('for', 'password')->create()
    ->initPasswordBox()->setName('password')->setAttribute('id', 'password')->create()
    ->initSubmit()->setAttribute('value', 'Register')->create()
    ->render(true);
?>