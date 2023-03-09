<?php

/* NB handle form before loading files that contain html because the user will be redirected to another page. No html characters should be sent ((nor locally, neither in production) to the server during a redirection */

// form was sent ?
if (!empty($_POST)) {
    // check required form fields
    if (isset($_POST["username"], $_POST["email"], $_POST["password1"], $_POST["password2"]) && !empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password1"]) && !empty($_POST["password2"])) {

        // get form data and protect them
        $username = strip_tags($_POST["username"]);

        // email validation
        $email = $_POST["email"];
        /* check email format with regex or filter_var($email, FILTER_VALIDATE_EMAIL) */
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Please provide a valid email address");
        }

        // connect to database
        require_once "./includes/connect.php";

        // check that email doesn't exist in bdd
        $emailStatement = $db->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $emailStatement->bindValue(":email", $email, PDO::PARAM_STR);
        $emailStatement->execute();

        // fetch result
        $user = $emailStatement->fetch();

        // if user with this email is found, error msg
        if ($user) {
            die("This email address is already registered");
        }

        // password validation
        /* NB password confirmation = nowadays, trend = no matching for email and password in registration forms (google still does it...) instead, send email with verification link + link to reset password in the login form and in the user dashboard */

        if ($_POST["password1"] !== $_POST["password2"]) {
            die("Passwords don't match");
        }

        /* hash password 2 
        NB md5 and sha1 are decipherable/reversible algorithms, not for hashing => don't use to hide data
        password_hash => the same pw hashed several times will have different hashed versions */
        $password = password_hash($_POST["password2"], PASSWORD_ARGON2ID);


        /* $password is hashed so it can be passed directly but within '', roles as well, in json */
        $sql = "INSERT INTO `users`(`username`, `email`, `password`, `roles`) VALUES(:username, :email, '$password', '[\"ROLE_USER\"]')";

        $statement = $db->prepare($sql);
        $statement->bindValue(":username", $username, PDO::PARAM_STR);
        $statement->bindValue(":email", $email, PDO::PARAM_STR);

        $statement->execute();

        // TODO: log new user in
    } else {
        // form is incomplete (+ required in html)
        die("Form is incomplete");
    }
}



/* define title before including header */
$pageTitle = "Register";

/* require instead of include for css */
require_once "./includes/header.php";

// navbar
@include_once "./includes/navbar.php";
/* include hamburger nav */
@include_once "./includes/hamburger.php";
?>
<main>
    <h1>Register</h1>

    <form id="registrationForm" method="post">
        <div class="form-fields">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-fields">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
            <p class="error-message" id="emailMessage">Email is not valid</p>
        </div>
        <div class="form-fields">
            <label for="password1">Password</label>
            <input type="password" name="password1" id="password1" required>
        </div>
        <div class="form-fields">
            <label for="password2">Confirm your password</label>
            <input type="password" name="password2" id="password2" required>
            <p class="error-message" id="pwMessage">Passwords don't match</p>
            <div class="showpw-field">
                <label for="checkboxPW">Show password</label>
                <input type="checkbox" name="checkboxPW" id="checkboxPW">
            </div>
        </div>
        <button type="submit" class="violet-btn form-btn" id="registerBtn" disabled>Register &#128587;</button>
    </form>
</main>
<?php
/* include back to top anchor */
@include_once "./includes/backtotop.php";
/* include footer */
@include_once "./includes/footer.php";
?>