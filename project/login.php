<?php

/* NB handle form before loading files that contain html because the user will be redirected to another page. No html characters should be sent (nor locally, neither in production) to the server during a redirection */

// form was sent ?
if (!empty($_POST)) {
    // check required form fields
    if (isset($_POST["userEmail"], $_POST["userPassword"]) && !empty($_POST["userEmail"]) && !empty($_POST["userPassword"]) ) {
        // TODO: validation
    }
     
}



/* define title before including header */
$pageTitle = "Login";

/* require instead of include for css */
require_once "./includes/header.php";

// navbar
@include_once "./includes/navbar.php";
/* include hamburger nav */
@include_once "./includes/hamburger.php";
?>
<main>
    <h1>Log in</h1>

    <form id="loginForm" method="post">
        <div class="form-fields">
            <label for="userEmail">Email</label>
            <input type="email" name="userEmail" id="userEmail" required>
        </div>
        <div class="form-fields">
            <label for="userPassword">Password</label>
            <input type="password" name="userPassword" id="userPassword" required>
        </div>
        <div class="form-fields">
            <div class="showpw-field">
                <label for="showpwLog">Show password</label>
                <input type="checkbox" name="showpwLog" id="showpwLog">
            </div>
        </div>
        <button type="submit" class="violet-btn form-btn" id="loginBtn" disabled>Log in &#128640;</button>
    </form>
</main>
<?php
/* include back to top anchor */
@include_once "./includes/backtotop.php";
/* include footer */
@include_once "./includes/footer.php";
?>