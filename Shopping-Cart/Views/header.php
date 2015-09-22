<header>
    <h1 style="color: blue">Header</h1>
    <?php
    if (!\FTS\App::getInstance()->getSession()->_login) {
        \FTS\FormViewHelper::init()
            ->initForm('/home/login')
            ->initLabel()->setValue("Username")->setAttribute('for', 'username')->create()
            ->initTextBox()->setName('username')->setAttribute('id', 'username')->create()
            ->initLabel()->setValue("Password")->setAttribute('for', 'password')->create()
            ->initPasswordBox()->setName('password')->setAttribute('id', 'password')->create()
            ->initSubmit()->setAttribute('value', 'Login')->create()
            ->render();
        \FTS\FormViewHelper::init()
            ->initForm('/home/register')
            ->initLabel()->setValue("Username")->setAttribute('for', 'username')->create()
            ->initTextBox()->setName('username')->setAttribute('id', 'username')->create()
            ->initLabel()->setValue("Password")->setAttribute('for', 'password')->create()
            ->initPasswordBox()->setName('password')->setAttribute('id', 'password')->create()
            ->initSubmit()->setAttribute('value', 'Register')->create()
            ->render(true);
    } else {
        \FTS\FormViewHelper::init()
            ->initLink()->setAttribute('href', '/home/logout')->setValue('Logout')->create()
            ->render();
    }
    ?>
</header>