<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><a
                href="/product/<?= $this->_viewBag['body']->getId() ?>/show"><?= $this->_viewBag['body']->getName() ?></a>
        </h3>
    </div>
    <div class="panel-body">
        <div>Description: <?= $this->_viewBag['body']->getDescription() ?></div>
        <div>Price: <?= $this->_viewBag['body']->getPrice() ?> lv.</div>
        <div>Quantity: <?= $this->_viewBag['body']->getQuantity() ?> remaining</div>
        <div>
            <a href="/categories/<?= $this->_viewBag['body']->getCategory() ?>/0/3">Category: <?= $this->_viewBag['body']->getCategory() ?></a>
        </div>
        <?php if (\FTS\App::getInstance()->isLogged()) : ?>
            <div id="btn" class="panel panel-primary btn btn-default"
                 onclick="sentCart(<?= $this->_viewBag['body']->getId() ?>)"
                >Add to cart
            </div>
        <?php else: ?>
            <a href="/home/login" class="panel panel-primary btn btn-default">Login to add to cart!</a>
        <?php endif ?>
    </div>
</div>