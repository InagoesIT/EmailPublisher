<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
        <link rel="icon" type="image/png" href="images/logo.png">
        <title>Email Publisher User Guide</title>
        <link rel="stylesheet" href="https://w3c.github.io/scholarly-html/css/scholarly.min.css">
        <script src="https://w3c.github.io/scholarly-html/js/scholarly.min.js"></script>
    </head>

    <body>
        <header>
            <div class="banner">
                <img src="images/logo.png" width="227" height="50" alt="Email Publisher logo">
            </div>
            <h1>Email Publisher User Guide</h1>
        </header>

        <div role="contentinfo">
            <dl>
                <dt>Authors</dt>
                <dd>
                    <a href="https://github.com/Raul-Madalin" target="_blank">Boboc Raul Madalin</a>,
                    <a href="https://github.com/paulamalina" target="_blank">Pastragus Malina-Paula</a>,
                    <a href="https://github.com/InagoesIT" target="_blank">Vivdici Ina</a>
                </dd>
            </dl>
        </div>

        <section typeof="sa:Abstract" id="abstract" role="doc-abstract">
            <h2>Abstract</h2>
            <p>
                This document describes how this app can be used and the features it has.
            </p>
        </section>

        <!--2. Authentication-->
        <section id="authentication" role="doc-introduction">
            <h2>Authentication</h2>
            <section id="how-to">
                <h3>How-to</h3>
                <ol>
                    <li>Access the main page of the app and click the <i>"Get started"</i> button.</li>
                    <li>You are now on the authentication page. Type an email you have access to and that you want to use for this site.</li>
                    <li>Click the green <i>"Continue"</i> button. You will receive an token on the given email address.</li>
                    <li>Open your email on the email management system of your choice (e.g. yahoo, gmail etc.) and copy the 8-character long token.</li>
                    <li>Go back to our site, you will be on the page where the token is needed. You can do 2 things here:
                        <ul>
                            <li>Click the grey <i>"go back"</i> button and choose another email where to get your token. You will be redirected to the step 2.</li>
                            <li>Click the green <i>"submit"</i> button and log in with the given token and email.</li>
                        </ul>
                    </li>
                    <li>
                        If the token you typed was valid you will be redirected to the main page where you can see all of your publications. 
                        If not, you will see a red message which states that the token isn't valid. You will need to type in a valid token.</li>
                </ol>
                <p>
                    Once authenticated, you can logout by clicking the white <i>"Logout"</i> button from the top-right corner of the page.
                </p>
                <figure typeof="sa:image" >
                    <img src="images/auth_help.png" width="1000" alt="Some pages from email publisher">
                    <figcaption>The pages you will see while following the steps</figcaption>
                </figure>
            </section>
        </section>

        <!--3. Send an email -->
        <section id="send-email" role="doc-introduction">
            <h2>Sending an email to be published</h2>

            <section id="where-to-send">
                <h3>Where and how to send it?</h3>
                <ol>
                    <li>Open your preffered email management system.</li>
                    <li>Open the email you want to be published.</li>
                    <li>Write the receiver as <i>emailpublisherweb@gmail.com</i>.</li>
                    <li>If you want to choose custom email publication parameters type them in the subject. (Details on how to do this in the next section)
                        No need to worry, though, you can change these after publishing an email too.
                    </li>
                    <li>Send the email.</li>
                    <li>You will receive an email containing the link for your publication and its name, by clicking on it you can see it. 
                        Alternatively, you can see it in the main page after authentication.</li>
                </ol>
            </section>
        </section>

        <!--4.Tags system-->
        <section id="tags-system">
            <h2>The <i>tag</i> system for the publications</h2>
            <section id="tags-meaning">
                <h3>What does every tag mean?</h3>
                <ul>
                    <li>
                        Visibility
                        <ul>
                            <li><i>private</i> - no one will be able to see the publication</li>
                            <li><i>public</i> - everyone will be able to see the publication (if you won't set a password for it)</li>
                        </ul>
                    </li>                  

                    <li>
                        Duration
                        <br>
                        When this time expires, your publication will be deleted. You can choose the number of days, hours and minutes for this.
                    </li>

                    <li>
                        Password
                        <br>
                        You can leave this field blank or write a password for the publication. Anyone who will want to access this public publication will need to know the password.
                    </li>
                </ul>
            </section>

            <section id="tags-meaning">
                <h3>How can we set the tags when publishing an email?</h3>
                <ul>
                    <li>
                        Visibility
                        <ul>
                            <li><i>private</i> - add <i>[private]</i> in the email subject</li>
                            <li><i>public</i> - add <i>[public]</i> in the email subject</li>
                        </ul>
                    </li>   
                    <li id="duration-tag">
                        Duration
                        <br>
                        Add <i>[duration=?]</i> in the email subject. <i>?</i> can be a combination of days, hours and minutes. 
                        <i>d</i> stands for days, <i>h</i> stands for hours and <i>m</i> stands for minutes. So, if you want 5 days to be the duration
                        you would write [duration=5d], if you want 5 days and 3 minutes you would write [duration=5d3m]. Possible combinations are: 
                        <i>?d?h?m, ?d?h, ?d?m, ?d, ?h?m...</i> etc, where <i>?</i> stands for the amounts of days, hours and minutes respectively.
                    </li>
                    <li>
                        Password
                        <br>
                        Add <i>[password=?]</i> in the email subject, where <i>?</i> stands for the password you want the publication to have.
                    </li>
                </ul>
            </section>

            <section id="tags-meaning">
                <h3>How can we change the tags of a publication?</h3>
                <ol>
                    <li>Authenticate.</li>
                    <li>On the home page click on the "Change tags" button for the publication you want to change the tags for.</li>
                    <li>
                        Now, type in the desired tags for the publication:
                        <ul>
                            <li><i>Visibility</i> - <i>private</i> or <i>public</i></li>
                            <li><i>Password</i> - type here the password you want the publication to have, if you don't want any password, leave this field blank.</li>
                            <li><i>Duration</i> - type the combination of d, m and s as was instructed <a href="#duration-tag">above</a> for the tags contained in an email. </li>                 
                        </ul>
                    </li>
                    <li>Click the green <i>"continue"</i> button.</li>   
                    <li>Now the tags for your publication will be updated.</li>                 
                </ol>
            </section>
        </section>

        <!--5.Statistics-->
        <section id="statistics">
            <h2>View the statistics of a publication</h2>
            <section id="how-to-statistics">
                <h3>How can I view the statistics of a publication?</h3>
                <ol>
                    <li>Authenticate.</li>
                    <li>Find the publication you want to view statistics for and click on the "Statistics" button of a publication.</li>
                    <li>You will be redirected to the page where you can view the statistics.</li>
                    <li>If you want to change the period of time you want to see the statistics for, choose the start and end date from the top of the page and click submit.</li>
                    <li>If you want to export a diagram click on the button near it named "export" and choose an export format.</li>
                </ol>
            </section>
        </section>

    </body>
</html>
