<?php
/* check if id was passed in url */
/* to avoid else, reverse check => if id isn't defined or is empty */
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    // redirection or 404 page
    header("Location: ../project/blog.php");
    // end script (nothing after this will be executed)
    exit;
}

// retrieved id
$id = $_GET["id"];

// connect to database
require_once "./includes/connect.php";

// protected query statement with id as sql param
$sql = "SELECT * FROM `articles` WHERE `id` = :id";

$statement = $db->prepare($sql);

// inject param and check that id is an integer
$statement->bindValue(":id", $id, PDO::PARAM_INT);

$statement->execute();

// fetch article
$article = $statement->fetch();

// if article is empty (unexisting article id)
if (!$article) {
    http_response_code(404);
    header("Location: ../project/not_found.php");
    exit;
}

extract($article);

/* define page title */
$pageTitle = strip_tags($title);
/* header */
require_once "./includes/header.php";

// to call my functions
require_once "./includes/functions.php";

/* remove time from datetime and format */
$formattedDate = "";
$formattedDate = formatDate($created_at, $formattedDate);


/* TODO: store likes and shares in db ? for now = js */

// navbar
@include_once "./includes/navbar.php";
/* include hamburger nav */
@include_once "./includes/hamburger.php";
?>
<main>
    <h1 class="article-title"><?= strip_tags($title) ?></h1>

    <ul class="breadcrumb">
        <li><a href="/project/welcome.php#">Home</a></li>\
        <li><a href="/project/blog.php">All articles</a></li>\
        <li><strong><?= strip_tags($title) ?></strong></li>
    </ul>

    <article class="article-single">
        <img src="<?= strip_tags($image_url) ?>" alt="article img" title="Article illustration" class="border">
        <p><small><?= $formattedDate ?></small></p>
        <div>
            <?php
            /*
            check if content has line returns => if not, 
            split the text into 4 sentence paragraphs after certain punctuation separators and implode inside foreach loop in html
            else replace line returns with br tags and echo
            */
            // preg_match() :int|false
            $hasLineReturn = preg_match('/[\r\n]/', $content);
            $paragraphs = "";

            if ($hasLineReturn == false) {
                // split the content at punctuation separators (:array)
                $splitContent = preg_split('/[\.\?\!\.{3}]/', $content);
                // remove empty strings and reindex array
                $splitContent = array_values(array_filter($splitContent));
                // create subarrays
                $paragraphs = array_chunk($splitContent, 4);

                // loop to create paragraphs
                foreach ($paragraphs as $paragraph) {
                    /* implode => turn subarrays back into strings and use ". " as separator */
                    $restring = implode(". ", $paragraph);
                    // if ending comma is missing
                    if (!str_ends_with(". ", $restring)) {
                        $text = $restring . ".";
                        echo "<p>" . strip_tags($text) . "</p>";
                    } else {
                        echo "<p>" . strip_tags($restring) . "</p>";
                    }
                }
            } else {
                $replaceLineReturn = preg_replace('/[\r\n]/', "<br/>", $content);
                echo $replaceLineReturn;
            }
            ?>
        </div>
    </article>

    <div id="actionsId" class="actions">
        <h2>You enjoyed this article, right?</h2>
        <h4>Let us know what you think</h4>
        <div>
            &#128156;
            <input type="button" value="0" class="violet-btn border" data-counterup>
        </div>
        <div>
            &#10060;
            <input type="button" value="0" class="violet-btn border" data-counterdown>
        </div>
        <div>
            <details>
                <summary class="violet-btn border">&#127757; Share</summary>
                <img src="../public/assets/discord.png" alt="social media icon" class="actions-icon">
                <input type="button" value="0" class="violet-btn border" data-counterup>
                <img src="../public/assets/github.png" alt="social media icon" class="actions-icon">
                <input type="button" value="0" class="violet-btn border" data-counterup>
                <img src="../public/assets/twitter.png" alt="social media icon" class="actions-icon">
                <input type="button" value="0" class="violet-btn border" data-counterup>
            </details>
        </div>
    </div>
</main>
<?php
/* include back to top anchor */
@include_once "./includes/backtotop.php";
/* include footer */
@include_once "./includes/footer.php";
?>