<?php 

require 'vendor/autoload.php';
use Parse\ParseObject;
use Parse\ParseUser;
use Parse\ParseException;
use Parse\ParseClient;
use Parse\ParseSessionStorage;
use Parse\ParseInstallation;
use Parse\ParseQuery;
use Parse\ParsePush;

// Start the session
session_start();

$app_id = "kddcodGlyJ6DmGI7FihXt8BsXyOTS09Dgpj8UA49";
$rest_key = "ryU6g6D37JtDqIAnPbTq4SLNmihEIy8kSNPZxlhj";
$master_key = "Fm9X40ewplSIEDTOmYxVdCEN7ge31vgfFwScYr3y";

ParseClient::initialize( $app_id, $rest_key, $master_key );

if(isset($_SESSION["username"])) {
    if(isset($_POST["message"]) && $_POST["message"] != "" && isset($_POST["inputEmail"]) && $_POST["inputEmail"] != "") {
        $ping = new ParseObject("Pings");
        $ping->set("Title","TLC Helpdesk"); //Auto set, we change later if need be
        $ping->set("Message",$_POST["message"]);
        
        
        try {
            $query = new ParseQuery($class = '_User');
            $query->equalTo("email", $_POST["inputEmail"]);
            $user = $query->first();
            //print_r($user);
            //$ping->save();
            //print "<br/>Test1";
            $relation = $ping->getRelation("User");
            //print "<br/>Test2";
            $relation->add($user);
            //print "<br/>Test3";
            $ping->save();
            //print "<br/>Test4";
            
            // $push = ParseInstallation::query();
            // //print "<br/>Test5";
            // $push->equalTo('user', $user->getObjectId());
            // //print "<br/>Test6";
            
            // //print
            
            // ParsePush::send(array(
            //     "where" => $push,
            //     "data" => array(
            //         "alert" => $_POST["message"]
            //     )
            // ));
            
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