<h2 class="form-group">Username: <?= ucfirst($this->_viewBag['body']->getUsername()) ?>
    <?php if ($this->_viewBag['body']->getIsAdmin()) : ?>
        <span class="label label-danger">Admin</span>
    <?php endif; ?>
    <?php if ($this->_viewBag['body']->getIsEditor()) : ?>
        <span class="label label-info">Editor</span>
    <?php endif; ?>
</h2>
<?php if (strtolower($this->_viewBag['body']->getUsername()) === strtolower(\FTS\App::getInstance()->getUsername())) : ?>
    <div class="panel panel-heading">Your balance: <?= $this->_viewBag['body']->getBalance()?>lv</div>
    <?php
    \FTS\FormViewHelper::init()
        ->initForm('/user/changePass', ['class' => 'form-group'], 'put')
        ->initLabel()->setValue("Old Password")->setAttribute('for', 'oldPassword')->create()
        ->initPasswordBox()->setAttribute('id', 'oldPassword')->setName('oldPassword')->setAttribute('class', 'form-control input-md')->create()
        ->initLabel()->setValue("New Password")->setAttribute('for', 'newPassword')->create()
        ->initPasswordBox()->setAttribute('id', 'newPassword')->setName('newPassword')->setAttribute('class', 'form-control input-md')->create()
        ->initLabel()->setValue("Confirm Password")->setAttribute('for', 'conPassword')->create()
        ->initPasswordBox()->setAttribute('id', 'conPassword')->setName('confirm')->setAttribute('class', 'form-control input-md')->create()
        ->initSubmit()->setAttribute('value', 'Change password')->setAttribute('class', 'btn btn-default')->create()
        ->render();
endif ?>