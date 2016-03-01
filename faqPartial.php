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

$app_id = "kddcodGlyJ6DmGI7FihXt8BsXyOTS09Dgpj8UA49";
$rest_key = "ryU6g6D37JtDqIAnPbTq4SLNmihEIy8kSNPZxlhj";
$master_key = "Fm9X40ewplSIEDTOmYxVdCEN7ge31vgfFwScYr3y";

ParseClient::initialize( $app_id, $rest_key, $master_key );

try {
    $query = new ParseQuery("FAQ_Category");    
    $query->each(function($category) {
        $questions = $category->getRelation("Questions");
   
        echo "<h4>".$category->get("Text")."</h4>";
        echo "<ul>";
        
        $questions->getQuery()->each(function($qa) {
            echo "<li>Question: ".$qa->get("Text")."</li>";
            echo "<li>Answer: ".$qa->get("AnswerText")."</li>";
            echo "<form action='rmvQuestion.php' method='post'>";
            echo "<input type='hidden' name='questionId' value='".$qa->getObjectId()."'>";
            echo "<button type='submit' class='btn btn-sm btn-danger'>Delete</button>";
            echo "</form>";
            echo "<br/>";
        });
        
        echo "</ul>";
    });
    
} catch (ParseException $error) {
    // The login failed. Check error to see why.
    echo $error->getMessage();
}



?>