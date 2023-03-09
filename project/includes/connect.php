<?php
// TODO: put in a .env file
// env variables
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "tutos_php");

// define data source name for the connection
$dsn = "mysql:dbname=" . DBNAME . ";host=" . DBHOST;

try{
    /* instanciate PDO (PHP Data Object, database access layer to simplify db operations and management) */
    $db = new PDO($dsn, DBUSER, DBPASS);

    // set charset
    $db->exec("SET NAMES utf8");

    // set default data fetch mode
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}catch(PDOException $e){
    // get error message
    die("Error: " . $e->getMessage());
};


