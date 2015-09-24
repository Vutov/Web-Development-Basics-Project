<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">FTS Cart</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><?php FTS\FormViewHelper::init()
                            ->initLink()->setAttribute('href', '/')->setValue('Home')->create()
                            ->render(); ?></li>
                    <?php if (!\FTS\App::getInstance()->isLogged()) : ?>
                        <li><?php \FTS\FormViewHelper::init()
                                ->initLink()->setAttribute('href', '/home/login')->setValue('Login')->create()
                                ->render(); ?></li>
                        <li><?php \FTS\FormViewHelper::init()
                                ->initLink()->setAttribute('href', '/home/login')->setValue('Register')->create()
                                ->render(); ?></li>
                    <? endif; ?>
                    <li><?php \FTS\FormViewHelper::init()
                            ->initLink()->setAttribute('href', '/api')->setValue('API')->create()
                            ->render(); ?></li>
                    <li><?php \FTS\FormViewHelper::init()
                            ->initLink()->setAttribute('href', '/api/ajax')->setValue('Ajax test')->create()
                            ->render(); ?></li>
                </ul>
                <?php if (\FTS\App::getInstance()->isLogged()) : ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true"
                               aria-expanded="false"><?= \FTS\App::getInstance()->getUsername() ?><span
                                    class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><?= \FTS\FormViewHelper::init()
                                        ->initLink()
                                        ->setAttribute('href', "/user/" . \FTS\App::getInstance()->getUsername() . "/profile")
                                        ->setValue('Profile')
                                        ->create()
                                        ->render(); ?></li>
                                <?php if (\FTS\App::getInstance()->isAdmin()) : ?>
                                    <li><a href="/admin">Admin</a></li>
                                <?php endif; ?>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <?php FTS\FormViewHelper::init()
                                        ->initLink()->setAttribute('href', '/user/logout')->setValue('Logout')->create()
                                        ->render();
                                    ?>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>