<?php

/* FETCH DATA FROM DB */
/* it is recommended to fetch data from the db at the top of the file, but here we need to import the header first */
// connect to database
require_once "./includes/connect.php";
/* unprepared query statement since there are no external params */
$sql = "SELECT * FROM `articles` ORDER BY `created_at` DESC";
$statement = $db->query($sql);
$articles = $statement->fetchAll();

/* display articles in html with a foreach loop */

// to call my functions
require_once "./includes/functions.php";


/* define title before including header */
$pageTitle = "Our Blog";

/* require instead of include for css */
require_once "./includes/header.php";

// navbar
@include_once "./includes/navbar.php";
/* include hamburger nav */
@include_once "./includes/hamburger.php";
?>
<main>
    <h1>Our Articles</h1>
    <section id="articlesId" class="articles">
        <?php foreach ($articles as $article) :
            extract($article);
            /* slice content if it's more than x characters and replace last character with three dots */
            $content = substr($content, 0, 60) . "...";
            /* remove time from datetime and format */
            $formattedDate = "";
            $formattedDate = formatDate($created_at, $formattedDate);

            /* NB it is recommended to protect the content by adding strip_tags on display, to escape the html code that could have been inserted in the db (unless it was authorized) 
            datetime should be automatically protected by sql */
        ?>
            <article class="article-cards border">
                <img src="<?= strip_tags($image_url) ?>" alt="article img" title="Article illustration" class="border">
                <h3><?= strip_tags($title) ?></h3>
                <small><?= $formattedDate ?></small>
                <div><?= strip_tags($content) ?></div>
                <p><a href="../project/article.php?id=<?= $id ?>">Read</a></p>
            </article>
        <?php endforeach; // use alt end statements instead of accolades for readability 
        ?>
    </section>
</main>
<?php
/* include back to top anchor */
@include_once "./includes/backtotop.php";
/* include footer */
@include_once "./includes/footer.php";
?>


