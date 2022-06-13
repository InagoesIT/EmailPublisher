<div class="auth-token-wrapper">
    <img class="logo" src="images/logo.png" alt="Email Publisher name wrapped by leaves crown">
    <form action="" method="post" class="auth-form">
        <div class="input-label">
            <label for="auth-token" id="auth-token">we just sent you a verification token via email. please enter it
                below ✨</label>
        </div>
        <div class="input-wrapper">
            <input name="token" type="text" id="auth-token" class="input" maxlength="8" minlength="8" required>
            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M10 16c0-1.104.896-2 2-2s2 .896 2 2c0 .738-.404 1.376-1 1.723v2.277h-2v-2.277c-.596-.347-1-.985-1-1.723zm11-6v14h-18v-14h3v-4c0-3.313 2.687-6 6-6s6 2.687 6 6v4h3zm-13 0h8v-4c0-2.206-1.795-4-4-4s-4 1.794-4 4v4zm11 2h-14v10h14v-10z"/>
            </svg>
        </div>
        {{error}}
        <div class="auth-token-button-wrapper">
            <button type="button" class="back-button auth-button" onClick="window.location.href='/auth'">go
                back
            </button>
            <button type="submit" class="submit-button auth-button">submit</button>
        </div>
    </form>
</div>