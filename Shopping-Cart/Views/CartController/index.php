<?php
if (!$this->_viewBag['body']->getProducts()) :?>
    <h1 class="alert alert-danger text-center">Your cart is empty!</h1>
<?php endif; ?>
    <h1 class="row text-center">
        <div class="col-sm-6">Total price: <?= $this->_viewBag['body']->getTotalSum() ?>lv</div>

        <div class="col-sm-6">checkout</div>
    </h1>
<?php foreach ($this->_viewBag['body']->getProducts() as $product) : ?>
    <div class="panel col-sm-3">
        <h3 class="panel-primary"><a href="product/<?= $product->getId() ?>/show"><?= $product->getName() ?></a>
        </h3>

        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6 text">Price: <?= $product->getPrice() ?> lv.</div>
                <!--panel panel-primary btn btn-default col-sm-6-->
                <?php
                \FTS\FormViewHelper::init()
                    ->initForm('/cart/remove/' . $product->getId(), array(), 'delete')
                    ->initSubmit()->setAttribute('value', 'Remove')->setAttribute('class', 'panel panel-primary btn btn-default col-sm-6')
                    ->create()
                    ->render(true);
                ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>