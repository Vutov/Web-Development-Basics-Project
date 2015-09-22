<h1>Admin</h1>
<h2>Index page</h2>
<div>Username: <?= $this->_viewBag['body']->getName() ?> </div>
<?php
\FTS\FormViewHelper::init()
    ->initTextBox()->setAttribute('class', 'some')->setName('username')->setAttribute('value','pesho')->create()
    ->render();
?>
<div>Password: <?= $this->_viewBag['body']->getPassword() ?> </div>
<div>Is Admin: <?= $this->_viewBag['body']->getAdmin() ?> </div>
<?php
\FTS\FormViewHelper::init()->initForm('/custom/as/create')->initTextBox()->setAttribute('value',"test")->create()
    ->initLabel()->setValue('Password')->setAttribute('for', 'password')->create()
    ->initPasswordBox()->setName("password")->setAttribute('id', 'password')->setName('password')->create()
    ->initSubmit()->setAttribute('value','Submit')->setName('some')->create()->render();
?>