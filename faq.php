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

if(isset($_POST["categoryId"]) && $_POST["categoryId"] != "" && isset($_POST["question"]) && $_POST["question"] != "" && strlen($_POST["question"]) <= 110 && isset($_POST["answer"]) && $_POST["answer"] != "" && strlen($_POST["answer"]) <= 255) {
    $query = new ParseQuery("FAQ_Category");
    try {
        $category = $query->get($_POST["categoryId"]);
        
        $questions = $category->getRelation("Questions");
        
        $newQuestion = new ParseObject("FAQ_Question");
        $newQuestion->set("Text",$_POST["question"]);
        $newQuestion->set("AnswerText",$_POST["answer"]);
        
        $questions->add($newQuestion);
        
        $newQuestion->save();
        $category->save();
        
        // The object was retrieved successfully.
    } catch (ParseException $ex) {
        // The object was not retrieved successfully.
        setcookie("modError",$ex->getMessage());
    }
}
else if(!isset($_POST["categoryId"]) || $_POST["categoryId"] == "") {
    setcookie("modError","Category not selected");
}
else if(!isset($_POST["question"]) || $_POST["question"] == "") {
    setcookie("modError","Question required");
}
else if(!isset($_POST["answer"]) || $_POST["answer"] == "") {
    setcookie("modError","Answer required");
}
else if(strlen($_POST["question"]) > 110) {
    setcookie("modError","Question cannot contain more than 110 characters");
}
else if(strlen($_POST["answer"]) > 1000) {
    setcookie("modError","Answer cannot contain more than 1000 characters");
}

header("Location: index.php"); /* Redirect browser */
exit();

?>