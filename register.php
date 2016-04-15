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

$user = new ParseUser();

if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["friendly"]) && $_POST["username"] != "" && $_POST["password"] != "" && $_POST["friendly"] != "") {
    
    $email = $_POST["username"];
    $pass = $_POST["password"];
    $suffix = substr($email, strpos($email, '@'));
    
    if(strtolower($suffix) != "@gcc.edu") {
        setcookie("regError","Must be a gcc.edu email");
        header("Location: index.php"); /* Redirect browser */
        exit();
    }
    
    if(strlen($pass) < 8) {
        setcookie("regError","Password must be at least 8 characters");
        header("Location: index.php"); /* Redirect browser */
        exit();
    }
    
    //Will remove any numbers, thus if no numbers exist it will match the length
    if(strcspn($pass, '0123456789') == strlen($pass)) {
        setcookie("regError","Password must contain numbers");
        header("Location: index.php"); /* Redirect browser */
        exit();
    }
    
    //Will remove any numbers, thus if it is all numbers the length will be 0
    if(strcspn($pass, '0123456789') == 0) {
        setcookie("regError","Password must contain letters");
        header("Location: index.php"); /* Redirect browser */
        exit();
    }
    
    /* set session storage */
    ParseClient::setStorage( new ParseSessionStorage() );

    try {
        $user->setUsername($_POST["username"]);
        $user->setEmail($_POST["username"]);
        $user->setPassword($_POST["password"]);
        $user->set("friendlyName",$_POST["friendly"]);
        $user->set("isAdmin",TRUE);
        $user->signUp();
        
        $_SESSION["username"] = ParseUser::getCurrentUser()->get("username");
        $_SESSION["friendlyName"] = ParseUser::getCurrentUser()->get("friendlyName");
    } catch (ParseException $ex) {
        // error in $ex->getMessage();
        setcookie("regError",$ex->getMessage());
    }
} 
else {
    setcookie("regError","Username, Password, and Chat Name are required");
}

header("Location: index.php"); /* Redirect browser */
exit();

?>