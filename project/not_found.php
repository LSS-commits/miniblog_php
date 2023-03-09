<?php

/* define title before including header */
$pageTitle = "Not found";

/* require instead of include for css */
require_once "./includes/header.php";
// navbar
@include_once "./includes/navbar.php";
/* include hamburger nav */
@include_once "./includes/hamburger.php";
?>
<main>
    <h1>Uh-oh...</h1>
    <h2>It could be you, or it could be us, but there's no page here!</h2>
    <img src="https://i.imgur.com/VAnsyjv.jpeg" alt="404 img" title="Page not found" class="not-found-img border">
</main>
<?php
/* include back to top anchor */
@include_once "./includes/backtotop.php";
/* include footer */
@include_once "./includes/footer.php";
?>