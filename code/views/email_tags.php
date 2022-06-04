<!-- This page represents the pop-up that will be shown after clicking the "Change tags" button from userMenu-->

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/email_tags.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>

<body>
    <div class="tags-popup-wrapper">
        <form class="tags-popup">
            <h1 class="tags-popup-title">Select tags:</h1>
            <div class="tags-popup-password">
                <h2 class="tags-popup-label tags-popup-text">Change password:</h2>
                <div class="tags-popup-no-password-wrapper tags-popup-text">
                    <input name="no-password" type="radio" value="no password" checked>
                    <label for="no-password" class="tags-popup-no-password ">no password</label>
                </div>
                <div class="password-input">
                    <input name="password" type="radio">
                    <input name="password" type="text">
                </div>
            </div>
            <div class="tags-popup-visibility">
                <h2 class="tags-popup-label tags-popup-text">Change visibility:</h2>
                <div class="tags-popup-visibility-public-wrapper tags-popup-text">
                    <input name="visibility-public" type="radio" value="public" checked>
                    <label for="visibility-public" class="tags-popup-visibility-private">public</label>
                </div>
                <div class="tags-popup-visibility-private-wrapper">
                    <input name="visibility-private" type="radio" value="private" >
                    <label for="visibility-private" class="tags-popup-visibility-public">private</label>
                </div>
            </div>
            <div class="tags-popup-date">
                <h2 class="tags-popup-label tags-popup-text">Change expiration date:</h2>
                <div class="tags-popup-no-expiration-wrapper tags-popup-text">
                    <input name="tags-popup-no-expiration" type="radio" value="no expiration date" checked>
                    <label for="tags-popup-no-expiration" class="tags-popup-no-expiration">no expiration date</label>
                </div>
                <div class="date-input">
                    <input name="date" type="radio">
                    <input name="date" type="date">
                </div>
            </div>
            <div class="tags-popup-buttons-wrapper">
                <button class="tags-popup-exit tags-popup-buttons" type="button">Exit</button>
                <button class="tags-popup-save tags-popup-buttons" type="submit">Save</button>
            </div>
        </form>
    </div>
</body>

</html>