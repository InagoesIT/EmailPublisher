<?php use app\core\App;?>

<h1>Hello, world!</h1>
<h3>Hi, <?php echo App::$app->user->getEmail()?></h3>