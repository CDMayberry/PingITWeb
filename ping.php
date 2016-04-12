<?php 

date_default_timezone_set('UTC');

// function getProperDateFormat($value)
// {
//     $dateFormatString = 'Y-m-d\TH:i:s.u';
//     $date = date_format($value, $dateFormatString);
//     $date = substr($date, 0, -3) . 'Z';
//     return $date;
// }

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
    if(isset($_POST["message"]) && $_POST["message"] != "" && strlen($_POST["message"]) <= 255 && isset($_POST["inputEmail"]) && $_POST["inputEmail"] != "") {
        $ping = new ParseObject("Pings");
        $ping->set("Title","TLC Helpdesk"); //Auto set, we change later if need be
        $ping->set("Message",$_POST["message"]);
        //$newDate = getProperDateFormat(new DateTime());
        $date = array(
        "__type" => "Date",
        "iso" => date("c")
        ); 
       
        $ping->setAssociativeArray("Date", $date);
        
        try {
            $query = new ParseQuery($class = '_User');
            $query->equalTo("email", $_POST["inputEmail"]);
            $user = $query->first();
            $relation = $ping->getRelation("User");
            $relation->add($user);
            $ping->save();

        } catch (ParseException $ex) {  
            /* Should pass back a cookie with the error $ex->getMessage() */    
            setcookie("modError",$ex->getMessage());
        }
    }
    else if(strlen($_POST["message"]) > 255) {
        setcookie("modError","Message cannot be more than 255 characters long");
    }
}

header("Location: index.php"); /* Redirect browser */
exit();

?>