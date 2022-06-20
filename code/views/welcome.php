<?php use app\core\View;

/** @var $this \app\core\View */

if (isset($_POST['email']))
	unset($_POST['email']);
?>

<div class="container" id="container1">
    <P>Do you want to publish your emails? Well, our site is your solution!</P>
    <img src="images/welcome.png" alt="1 person holds an email and the other one looks at a site">
    <div class="row">
        <button class="button" id="button1" onclick="window.location.href='/help'">Help</button>
        <button class="button" id="button2" onclick="window.location.href='/auth'">Get started</button>
    </div>
</div>
