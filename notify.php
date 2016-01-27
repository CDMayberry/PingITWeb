<?php 

// Start the session
session_start();

$email=$_POST["email"];

if(isset($_SESSION["username"])) {
    
}

if(!isset($_COOKIE["Posted"]) && isset($_POST["email"])) {
    setcookie("Posted",$_POST["email"]);
}

//print($_POST["email"]);

//echo "Posted: ".$email;

header("Location: index.php"); /* Redirect browser */
exit();

?>