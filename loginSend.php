<?php

require 'vendor/autoload.php';
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseClient;
use Parse\ParseSessionStorage;

// Start the session
session_start();

$app_id = "kddcodGlyJ6DmGI7FihXt8BsXyOTS09Dgpj8UA49";
$rest_key = "ryU6g6D37JtDqIAnPbTq4SLNmihEIy8kSNPZxlhj";
$master_key = "Fm9X40ewplSIEDTOmYxVdCEN7ge31vgfFwScYr3y";

ParseClient::initialize( $app_id, $rest_key, $master_key );

$modError = FALSE;

if(isset($_COOKIE["modError"])) {
    setcookie("modError","",1);
    $modError = TRUE;
}

$parseUser;

if(ParseUser::getCurrentUser() !== NULL) {
    //echo "<pre>";
    //print_r(ParseUser::getCurrentUser());
    //echo "</pre>";
    $parseUser = ParseUser::getCurrentUser();
  
    $_SESSION["username"] = $parseUser->get("username");
}
else {
    header("Location: index.php"); /* Redirect browser */
    exit();
}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <link rel="shortcut icon" href="https://s3.amazonaws.com/sendbird-static/favicon/favicon.ico" type="image/x-icon">

  <link href='https://fonts.googleapis.com/css?family=Exo+2:400,900italic,900,800italic,800,700italic,700,600italic,600,500italic,500,400italic,300italic,200italic,200,100italic,100,300' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Lato:400,900italic,900,800italic,800,700italic,700,600italic,600,500italic,500,400italic,300italic,200italic,200,100italic,100,300' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="static/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="static/css/sample-index.css">
  
  <script src="http://www.parsecdn.com/js/parse-1.2.13.min.js"></script>

  <title>Web SDK Sample</title>
</head>
<body class="sample-background">
  <div class="container">
    <div class="row">

      <!-- top -->
      <div class="index-section index-top">
        <div class="text-sort text-sort--right">
          <img src="static/img/logo_landing.svg">
        </div>
        <div class="text-sort text-sort--left">
          <label class="index-title">Sample Chat</label>
        </div>
      </div>

      <!-- nickname -->
      <div class="index-section index-input">
        <input type="text" class="index-nickname" maxlength="12" placeholder="Enter User nickname" id="user_nickname">
        <button type="button" class="index-button" id="btn_start">DONE</button>
      </div>

      <!-- description -->
      <div class="index-section index-text">
        Start chatting on SendBird by choosing your display name.<br>
        This can be changed anytime and will be shown on 1-on-1 and group messaging.
        <br />
        <br />
        <!--<a href="//github.com/smilefam/sendbird-sample/archive/master.zip" class="download-sample">Download Sample</a>-->
      </div>

      <!--<div class="index-section index-bottom">
        <img src="static/img/image-landing-01.png" width="624">
      </div>-->

    </div>
  </div>
  <!--<div style="text-align: center;">
    <img src="static/img/image-landing-02.png" width="960">
  </div>-->

  <script src="static/js/jquery-1.11.3.min.js"></script>
  <script src="static/js/util.js"></script>
  <script src="static/js/index.js"></script>

</body>
</html>