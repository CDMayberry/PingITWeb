<?php 

require 'vendor/autoload.php';
use Parse\ParseObject;
use Parse\ParseUser;
use Parse\ParseException;
use Parse\ParseClient;
use Parse\ParseSessionStorage;

// Start the session
session_start();

$app_id = "kddcodGlyJ6DmGI7FihXt8BsXyOTS09Dgpj8UA49";
$rest_key = "ryU6g6D37JtDqIAnPbTq4SLNmihEIy8kSNPZxlhj";
$master_key = "Fm9X40ewplSIEDTOmYxVdCEN7ge31vgfFwScYr3y";

ParseClient::initialize( $app_id, $rest_key, $master_key );

if(isset($_SESSION["username"])) {
    if(isset($_POST["message"]) && $_POST["message"] != "" && isset($_POST["inputEmail"]) && $_POST["inputEmail"] != "") {
        $ping = new ParseObject("Pings");
        $ping->set("Text",$_POST["message"]);
        try {
            //$ping->save();
        } catch (ParseException $ex) {  
            /* Should pass back a cookie with the error $ex->getMessage() */    
            setcookie("modError",$ex->getMessage());
        }
    }
}

header("Location: index.php"); /* Redirect browser */
exit();

?>