<?php
if (!$this->_viewBag['body']->getProducts()) :?>
    <h1 class="alert alert-danger text-center">No Products</h1>
<?php endif;
foreach ($this->_viewBag['body']->getProducts() as $product) :?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?= $product->getName() ?></h3>
        </div>
        <div class="panel-body">
            <div>Description: <?= $product->getDescription() ?></div>
            <div>Price: <?= $product->getPrice() ?></div>
            <div>Quantity: <?= $product->getQuantity() ?></div>
            <div>
                <a href="/categories/<?= $product->getCategory() ?>/0/3">Category: <?= $product->getCategory() ?></a>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<ul class="pager">
    <li><a href="/products/<?php
        $start = $this->_viewBag['body']->getStart();
        if ($start - 3 >= 0) {
            echo $start -= 3;
        } else {
            echo 0;
        }
        ?>/<?php
        $end = $this->_viewBag['body']->getEnd();
        if ($end - 3 > 0) {
            echo $end -= 3;
        } else {
            echo 3;
        }
        ?>">Previous</a></li>
    <li><a href="/products/<?php
        $start = $this->_viewBag['body']->getStart();
        echo $start += 3;
        ?>/<?php
        $end = $this->_viewBag['body']->getEnd();
        echo $end += 3;
        ?>"> Next</a></li>
</ul>