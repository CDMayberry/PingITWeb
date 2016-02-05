<?php 

require 'vendor/autoload.php';
use Parse\ParseObject;
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseException;
use Parse\ParseClient;
use Parse\ParseSessionStorage;

// Start the session
session_start();

$app_id = "kddcodGlyJ6DmGI7FihXt8BsXyOTS09Dgpj8UA49";
$rest_key = "ryU6g6D37JtDqIAnPbTq4SLNmihEIy8kSNPZxlhj";
$master_key = "Fm9X40ewplSIEDTOmYxVdCEN7ge31vgfFwScYr3y";

ParseClient::initialize( $app_id, $rest_key, $master_key );

if(isset($_POST["categoryId"]) && $_POST["categoryId"] != "") {
    $query = new ParseQuery("FAQ_Category");
    try {
        $category = $query->get($_POST["categoryId"]);
        $questions = $category->getRelation("Questions");
        
        $questions->getQuery()->each(function($qa) {
            $qa->destroy();
        });
        
        $category->destroy();
        // The object was retrieved successfully.
    } catch (ParseException $ex) {
        // The object was not retrieved successfully.
        // error is a ParseException with an error code and message.
        setcookie("modError",$ex->getMessage());
    }
}

header("Location: index.php"); /* Redirect browser */
exit();

?>