<?php
use app\core\App;
use app\models\Publication;
use app\models\User;
use \app\core\DbModel;
?>

<header>
    <div class="headerText">
        <h1>Hello,<?php echo App::$app->user->getEmail() ?>!</h1>
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
        <button type="button" class="pMail" onclick="window.location.href='<?php echo "https://680a-46-97-169-19.eu.ngrok.io/mail"?>'">Check Mail</button>
        <br><br>

        <?php
        $count = Publication::countAllUsers();
        if ($count > 1) {
            echo "<h2> All users:</h2>";
            $u = User::getUserPropriety('id');
        }
        else
            echo "<h2>No users</h2>";
        for($i = 0; $i < $count - 1 ; $i++): ?>
            <div class="publication">
                <div class="publicationLink">
                    <p class="pLink"><?php echo User::getUserMailById($u[$i])[0] ?></p>
                </div>
            </div>
        <?php endfor; ?>

        <br><br>

        <?php
        $count = Publication::countAllPublications();
        if ($count > 0) {
            echo "<h2> All publications:</h2>";
            $p = Publication::getPublicationPropriety('link');
            $u = Publication::getPublicationPropriety('idUser');
        }
        else
            echo "<h2>No publications</h2>";
        for($i = 0; $i < $count ; $i++): ?>
            <div class="publication">
                <!--                TODO: HARD CODED LINK !!!-->
                <div class="publicationLink">
                    <p class="pLink"><?php echo User::getUserMailById($u[$i])[0] ?></p>
                </div>
                <div class="publicationLink">
                    <a class="pLink" href="<?php echo "https://680a-46-97-169-19.eu.ngrok.io/publication/" . $p[$i] ?>"><?php echo $p[$i] ?></a>
                </div>
                <div class="publicationTags">
                    <button type="button" class="pTags" onclick="window.location.href='<?php echo "https://680a-46-97-169-19.eu.ngrok.io/publication/" . $p[$i] . "/changeTags" ?>';">Change Tags</button>
                </div>
                <div class="publicationStatistics">
                    <button type="button" class="pStatistics" onclick="window.location.href='<?php echo "https://680a-46-97-169-19.eu.ngrok.io/publication/" . $p[$i] . "/stats" ?>'">Statistics</button>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</main>