<?php
\FTS\FormViewHelper::init()
    ->initForm('/home/login')
    ->initLabel()->setValue("Username")->setAttribute('for', 'username')->create()
    ->initTextBox()->setName('username')->setAttribute('id', 'username')->create()
    ->initLabel()->setValue("Password")->setAttribute('for', 'password')->create()
    ->initPasswordBox()->setName('password')->setAttribute('id', 'password')->create()
    ->initSubmit()->setAttribute('value', 'Submit')->create()
    ->render();