<?php
/* define title before including header or use default value from header.php (??) */
$pageTitle = "Welcome";

/* require stops the exec of the code if file can't be found and throws a warning + fatal error or only fatal error if @require */
/* if require is set twice, can trigger a fatal error depending on what's inside the file: here, because a function can't be called twice 
require_once is safer (no fatal error), useful since require of same file can be set in different files */
// require_once "../includes/functions.php";

/* include doesn't stop the execution of the code if a file can't be found, throws an error but the other elements are rendered; no error is shown with @include */
/* include_once to ensure that even if a file is included several times, it is executed only once */

/* require instead of include for css */
require_once "./includes/header.php";
// navbar
@include_once "./includes/navbar.php";
/* include hamburger nav */
@include_once "./includes/hamburger.php";

?>
<main>
    <section id="bannerId" class="banner">
        <h1>This is PHP</h1>
    </section>
    <section id="aboutId" class="about">
        <h2>That's who we are</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque, necessitatibus obcaecati incidunt ex amet inventore?</p>
    </section>
    <section id="contactId" class="contact">
        <h2>We'd love to hear from you</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque, necessitatibus obcaecati incidunt ex amet inventore?</p>
    </section>
</main>
<?php
// connect to database
require_once "./includes/connect.php";

// give details of authenticated user

// manual request
// $sql = "SELECT * FROM `users` WHERE `username` = 'Hanguk' AND `password` = 'test'";

// simulate form request
$username = "Hanguk";
$password = "test";

/* works but not safe, should always check what's coming from a form with a prepared statement */
// $sql = "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password'";

/* ? => if a user knows that the website is fetching users data from a sql database and types for ex admin'; -- as username, can get all the info from this user (admin) even if password is incorrect (will return false if user does not exist in database) 
    => '; -- = SQL injection that comments the rest of the query statement. Here, one could access all the user's info with username only (what's written after ; -- is omitted)
*/
// $sql = "SELECT * FROM `users` WHERE `username` = 'ben'; --' AND `password` = '$password'";

/* SQL injection to get any/every user's info (depending on whether we do a fetch or fetchAll to get user data)
with any username and password, adding ' OR 1=1; -- 
means either username and password are correct OR select * from users = true (something is fetched from database) since 1=1 is always true
if the first condition is not verified, the WHERE filter is omitted, meaning select everything from users
*/
// $sql = "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = 'test' OR 1=1; --'";
// $statement = $db->query($sql);
// $user = $statement->fetch();

/* USE A PREPARED STATEMENT TO PROTECT THE DATABASE FROM SQL injections */

/* use ? to indicate that some values will be injected later */
// $sql = "SELECT * FROM `users` WHERE `username` =? AND `password` =?";

/* OR use SQL parameters */
$sql = "SELECT * FROM `users` WHERE `username` =:username AND `password` =:pw";


// prepare the query statement
$statement = $db->prepare($sql);

/* => use bindValue to indicate what data + type of data (or string by default if not indicated) to inject and where 
bindValue will escape the data individually (by adding "" around them, the strings will not be treated as SQL statements but as strings, hence the rest of the code will not be commented)
must be done for each parameter to escape, in order if ? are used, or in any order if SQL params are used */

// inject values with PDO function "bindValue" 
/* if PDO::PARAM_INT, bindValue will treat only numbers, no text */

// if ? in statement
// $statement->bindValue(1, $username, PDO::PARAM_STR);
// $statement->bindValue(2, $password, PDO::PARAM_STR);

// if SQL parameters
$statement->bindValue(":username", $username, PDO::PARAM_STR);
$statement->bindValue(":pw", $password, PDO::PARAM_STR);


/* NB: an injected value can't be modified after it was bound with bindValue. If use of fluctuant values that could be modified before the execute(), injected before being defined/edited, use bindParam */

// execute the query statement
$statement->execute();

/* NB: if all the input params of the SQL statement are strings, it is possible to skip bindValue and set all params inside the execute function; first, create an array with all the input params and pass this array as a param in execute() 
bindValue enables customization */

// fetch data
$user = $statement->fetch();


/* include back to top anchor */
@include_once "./includes/backtotop.php";
/* include footer */
@include_once "./includes/footer.php";
?>