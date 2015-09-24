<div class="input-group">
    <h1>Welcome to the Admin Home</h1>
    <h2>Here are all admins:</h2>
    <ul class="list-group">
        <?php foreach ($this->_viewBag['body']->getAdmins() as $key => $admin) : ?>
            <li class="list-group-item"><a href="/user/<?= $admin ?>/profile"><?= ucfirst($admin) ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>