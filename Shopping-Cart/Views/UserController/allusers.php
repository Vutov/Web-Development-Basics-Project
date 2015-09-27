<div class="row">
    <?php if (!$this->_viewBag['body']->getUsers()) : ?>
        <h1 class="alert alert-danger text-center">No Users!</h1>
    <?php endif;?>
    <ul class="list-group col-sm-6 col-sm-offset-3">
        <?php foreach ($this->_viewBag['body']->getUsers() as $user) : ?>
            <li class="list-group-item"><a href="/user/<?= $user->getUserName() ?>/profile"><?= ucfirst($user->getUserName()) ?></a>
                <?php if ($user->getIsAdmin()) : ?>
                    <span class="label label-danger">Admin</span>
                <?php endif; ?>
                <?php if ($user->getIsEditor()) : ?>
                    <span class="label label-info">Editor</span>
                <?php endif; ?>
                <?php if ($user->getIsModerator()) : ?>
                    <span class="label label-success">Moderator</span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<ul class="pager">
    <li><a href="/users/all/<?php
        $start = $this->_viewBag['body']->getStart();
        if ($start - 10 >= 0) {
            echo $start -= 10;
        } else {
            echo 0;
        }
        ?>/<?php
        $end = $this->_viewBag['body']->getEnd();
        if ($end - 10 > 0) {
            echo $end -= 10;
        } else {
            echo 10;
        }
        ?>">Previous</a></li>
    <?php if ($this->_viewBag['body']->getUsers()) : ?>
        <li><a href="/users/all/<?php
            $start = $this->_viewBag['body']->getStart();
            echo $start += 10;
            ?>/<?php
            $end = $this->_viewBag['body']->getEnd();
            echo $end += 10;
            ?>"> Next</a></li>
    <?php endif; ?>
</ul>