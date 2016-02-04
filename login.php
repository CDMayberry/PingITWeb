<?php 

require 'vendor/autoload.php';
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
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

$user = new ParseUser();

if(isset($_POST["username"]) && isset($_POST["password"]) && $_POST["username"] != "" && $_POST["password"] != "") {
    
    /* set session storage */
    ParseClient::setStorage( new ParseSessionStorage() );
    $username = explode("@",($_POST["username"]));

    try {
        $user = ParseUser::logIn($username[0], $_POST["password"]);
        $_SESSION["username"] = ParseUser::getCurrentUser()->get("username");
        // Do stuff after successful login.
    } catch (ParseException $ex) {
        // The login failed. Check error to see why.
        setcookie("loginError",$ex->getMessage());
    }
} 
else {
    setcookie("loginError","Failed to login");
}

header("Location: index.php"); /* Redirect browser */
exit();

?>