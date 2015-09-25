<div class="alert alert-success" role="alert" id="#" style="display: none"></div>

<?php
if (!$this->_viewBag['body']->getProducts()) :?>
    <h1 class="alert alert-danger text-center">No Products</h1>
<?php endif;
foreach ($this->_viewBag['body']->getProducts() as $product) :?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="/product/<?= $product->getId() ?>/show"><?= $product->getName() ?></a></h3>
        </div>
        <div class="panel-body">
            <div>Description: <?= $product->getDescription() ?></div>
            <div>Price: <?= $product->getPrice() ?>lv.</div>
            <div>Quantity: <?= $product->getQuantity() ?> remaining</div>
            <div>
                <a href="/categories/<?= $product->getCategory() ?>/0/3">Category: <?= $product->getCategory() ?></a>
            </div>
            <?php if (\FTS\App::getInstance()->isLogged()) : ?>
                <div id="btn" class="panel panel-primary btn btn-default"
                     onclick="sentAjax(<?= $product->getId() . ', \'' . $product->getName() . '\'' ?>)"
                    >Add to cart
                </div>
            <?php else: ?>
                <a href="/home/login" class="panel panel-primary btn btn-default">Login to add to cart!</a>
            <?php endif?>
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
    <?php if ($this->_viewBag['body']->getProducts()) : ?>
        <li><a href="/products/<?php
            $start = $this->_viewBag['body']->getStart();
            echo $start += 3;
            ?>/<?php
            $end = $this->_viewBag['body']->getEnd();
            echo $end += 3;
            ?>"> Next</a></li>
    <?php endif; ?>
</ul>

<script>
    function sentAjax(id, name) {
        $.ajax({
            method: "GET",
            url: "/cart/add/" + id,
            data: {}
        }).done(
            function (msg) {
                document.getElementById("#").style.display = 'block';
                document.getElementById("#").innerHTML = '"' + name + '" added to cart!';
            }
        );
    }
</script>