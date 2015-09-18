<h1>Admin</h1>
<h2>Index page</h2>
<?php foreach ($this->_viewBag as $item): ?>
    <div><?= $item ?></div>
<?php endforeach;?>
<div>Model is <?= $this->_viewBag['model'] ?></div>
