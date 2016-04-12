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

if(isset($_POST["category"]) && $_POST["category"] != "" && strlen($_POST["category"]) <= 45) {
    $category = new ParseObject("FAQ_Category");
    $category->set("Text",$_POST["category"]);
    try {
        $category->save();
    } catch (ParseException $ex) {  
        /* Should pass back a cookie with the error $ex->getMessage() */    
        setcookie("modError",$ex->getMessage());
    }
}
else if(strlen($_POST["category"]) > 45) {
    setcookie("modError","Category cannot contain more than 45 characters");
}

header("Location: index.php"); /* Redirect browser */
exit();

?>