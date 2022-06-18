<?php use app\core\App; ?>

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
        <h2>Your publications:</h2>
        <div class="publication">
            <div class="publicationTitle"><p class="pTitle">Title</p></div>
<!--            <div class="publicationLink"><a class="pLink" href="https://www.youtube.com"></a></div>-->
            <div class="publicationTags">
                <button type="button" class="pTags">Change Tags</button>
            </div>



            <div class="publicationStatistics">
                <button type="button" class="pStatistics" onclick="window.location.href='/stats'">Statistics</button>
            </div>



        </div>
        <div class="publication">
            <div class="publicationTitle"><p class="pTitle">Title</p></div>
<!--            <div class="publicationLink"><a class="pLink" href="Link">Link</a></div>-->
            <div class="publicationTags">
                <button type="button" class="pTags">Change Tags</button>
            </div>
            <div class="publicationStatistics">
                <button type="button" class="pStatistics">Statistics</button>
            </div>
        </div>
        <div class="publication">
            <div class="publicationTitle"><p class="pTitle">Title</p></div>
<!--            <div class="publicationLink"><a class="pLink" href="Link">Link</a></div>-->
            <div class="publicationTags">
                <button type="button" class="pTags">Change Tags</button>
            </div>
            <div class="publicationStatistics">
                <button type="button" class="pStatistics" onclick="window.location.href='/stats'">Statistics</button>
            </div>
        </div>
    </div>
</main>