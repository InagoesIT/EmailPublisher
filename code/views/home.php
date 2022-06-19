<?php
use app\core\App;
use app\models\Publication;
?>

<header>
    <div class="headerText">
        <h1>Hello, <?php echo App::$app->user->getEmail() ?> !</h1>
        <button type="button" class="pLogout" onclick="window.location.href='/logout'">Logout</button>
    </div>
</header>

<nav>
    <div class="logo">
        <img src="images/logo.png" alt="logo" style="width:100%;height:100%;">
    </div>
</nav>

<main>
    <div class="hline"></div>
    <div class="innertube">
        <?php
        $count = Publication::countPublicationOfUser(App::$app->user->getId());
        if ($count > 0) {
            echo "<h2> Your publications:</h2>";
            $p = Publication::getPublicationProprietyByUserId('link', App::$app->user->getId());
        }
        else
            echo "<h2>No publications</h2>";
        for($i = 0; $i < $count ; $i++): ?>
            <div class="publication">
<!--                TODO: HARD CODED LINK !!!-->
                <div class="publicationLink">
                    <a class="pLink" href="<?php echo "https://680a-46-97-169-19.eu.ngrok.io/publication/" . $p[$i] ?>"><?php echo $p[$i] ?></a>
                </div>
                <div class="publicationTags">
                    <button type="button" class="pTags">Change Tags</button>
                </div>
                <div class="publicationStatistics">
                    <button type="button" class="pStatistics" onclick="window.location.href='/stats'">Statistics</button>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</main>