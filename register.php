<?php 

require 'vendor/autoload.php';
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseException;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseClient;
use Parse\ParseSessionStorage;

/* Start session MUST be between autoload and intialization. */
session_start();

$app_id = "kddcodGlyJ6DmGI7FihXt8BsXyOTS09Dgpj8UA49";
$rest_key = "ryU6g6D37JtDqIAnPbTq4SLNmihEIy8kSNPZxlhj";
$master_key = "Fm9X40ewplSIEDTOmYxVdCEN7ge31vgfFwScYr3y";

ParseClient::initialize( $app_id, $rest_key, $master_key );

/* Backup logout info goes here  */
// if(isset($_SESSION["username"])) {
//     unset($_SESSION["username"]);
// }

header("Location: index.php"); /* Redirect browser */
exit();

$user = new ParseUser();

if(isset($_POST["username"]) && $_POST["username"] != "") {
    
    /* set session storage */
    ParseClient::setStorage( new ParseSessionStorage() );

    try {
        $user->signUp();
    } catch (ParseException $ex) {
        // error in $ex->getMessage();
        setcookie("regError","Failed to login");
    }
} 
else {
    setcookie("regError","Failed to login");
}

header("Location: index.php"); /* Redirect browser */
exit();

?>