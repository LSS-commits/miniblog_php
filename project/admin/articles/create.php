<?php
// title, content, image_url insert a default img https://picsum.photos/200/200
// (created_at auto, likes dislikes and shared null by default)

// handle form here (could be done in another file/page)

/* $_POST is not empty => check that data were sent */
if (!empty($_POST)) {

    /* isset(x parameters)=> exists ?, && !empty(1 parameter) */
    if (isset($_POST["title"], $_POST["content"]) && !empty($_POST["title"]) && !empty($_POST["content"])) {

        /* form is complete => get data + protect data (XSS) */
        // remove html tags where needed
        $title = strip_tags($_POST["title"]);

        /* or neutralize tags (remain inside the string but not active, won't be executed) 
            we can also filter/allow and neutralize specific tags by passing an array into strip_tags */
        $content = htmlspecialchars($_POST["content"]);

        // default img url
        $imageUrl = strip_tags("https://picsum.photos/200/200");

        // save data
        // connect to db
        require_once "../../includes/connect.php";
        // write query statement
        $sql = "INSERT INTO `articles` (`title`, `content`, `image_url`) VALUES (:title, :content, :imageUrl)";
        // prepare the qs
        $statement = $db->prepare($sql);
        // inject the values (str by default but we can still specify it here)
        $statement->bindValue(":title", $title, PDO::PARAM_STR);
        $statement->bindValue(":content", $content, PDO::PARAM_STR);
        $statement->bindValue(":imageUrl", $imageUrl, PDO::PARAM_STR);

        /* NB: if every parameter is treated as a string, we can bind all the values by passing them directly in an array within the arguments of execute() 
            $statement->execute(array(
                ':title' => $title,
                etc
            ));
            */

        // execute the qs (execute() returns a boolean)

        // error message
        if (!$statement->execute()) {
            die("Oups... An error occurred, please submit again");
        }

        // if successful, get the last article's id meaning last executed insert in the db
        $id = $db->lastInsertId();
        // success message
        die("Article $id was successfully submitted");
    } else {
        die("Please fill in the form");
    }
}

// TODO: display messages on form

$pageTitle = "Submit an article";
require_once "../../includes/header.php";

@include_once "../../includes/navbar.php";

@include_once "../../includes/hamburger.php";
?>

<main>
    <h1>Submit an article</h1>

    <form id="articleForm" method="post">
        <div class="form-fields">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div class="form-fields">
            <label for="content">Content</label>
            <textarea name="content" id="content" required></textarea>
        </div>
        <button type="submit" class="violet-btn form-btn" id="articleBtn" disabled>Submit &#129310;</button>
    </form>
</main>

<?php

@include_once "../../includes/backtotop.php";
@include_once "../../includes/footer.php";
