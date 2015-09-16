<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

use FTS\App;

include '../../FTS-Framework/App.php';

$app = App::getInstance();
$app->run();