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

//Start session MUST be between autoload and intialization.
session_start();

$app_id = "kddcodGlyJ6DmGI7FihXt8BsXyOTS09Dgpj8UA49";
$rest_key = "ryU6g6D37JtDqIAnPbTq4SLNmihEIy8kSNPZxlhj";
$master_key = "Fm9X40ewplSIEDTOmYxVdCEN7ge31vgfFwScYr3y";

ParseClient::initialize( $app_id, $rest_key, $master_key );
// if(isset($_SESSION["username"])) {
//     unset($_SESSION["username"]);
// }

$user = new ParseUser();

if(isset($_POST["username"])) {
    
    //setcookie("Test","Username exists", 15);
    if($_POST["username"] != "") {
        $_SESSION["username"] = $_POST["username"];
        //setcookie("Test","Username set", 15);
    }
    else if(false) {
        // set session storage
        ParseClient::setStorage( new ParseSessionStorage() );

        try {
            $user = ParseUser::logIn($_POST["username"], $_POST["password"]);
            // Do stuff after successful login.
        } catch (ParseException $error) {
            // The login failed. Check error to see why.
            setcookie("loginError","Failed to login");
        }
    } else {
        setcookie("loginError","Failed to login");
    }
}
else {
    setcookie("loginError","Failed to login");
    //setcookie("Test","No username found", 15);
}

header("Location: index.php"); /* Redirect browser */
exit();

?>