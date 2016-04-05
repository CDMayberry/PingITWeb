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

  <link rel="shortcut icon" href="sendbird_img_logo.png" />

  <link href='https://fonts.googleapis.com/css?family=Exo+2:400,900italic,900,800italic,800,700italic,700,600italic,600,500italic,500,400italic,300italic,200italic,200,100italic,100,300'
        rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Lato:400,900italic,900,800italic,800,700italic,700,600italic,600,500italic,500,400italic,300italic,200italic,200,100italic,100,300'
        rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="static/css/sample-chat.css">
  
  <script src="http://www.parsecdn.com/js/parse-1.2.13.min.js"></script>

  <title>Ping IT SendBird</title>
  
</head>
<body>
        <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">PingIT</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Chat</a>
                    </li>
                </ul>
                <ul class='nav navbar-nav navbar-right'>
                    <?php 
                    if(!isset($_SESSION["username"])) {
                        echo "<li><a id='loginUser' href='#' data-toggle='modal' data-target='#loginModal'>Login</a></li>";
                        echo "<li><a id='regUser' href='#' data-toggle='modal' data-target='#registerModal'>Register</a></li>";
                    }
                    else {
                        echo "<li><a href='#'>".$_SESSION["username"]."</a></li>";
                        echo "<li><a id='logoutUser' href='logout.php'>Logout</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    
  <div class="init-check"></div>

  <div class="sample-body" style="margin-top: 50px">

    <!-- left nav -->
    <div class="left-nav">
      <a href="//sendbird.com" target="_blank"><div class="left-nav-icon"></div></a>
      <div class="left-nav-channel-select">
        <button type="button" class="left-nav-button left-nav-open" id="btn_open_chat">
          OPEN CHAT
          <div class="left-nav-button-guide"></div>
        </button>
        <button type="button" class="left-nav-button left-nav-messaging" id="btn_messaging_chat">
          1ON1 & GROUP CHAT
          <div class="left-nav-button-guide"></div>
        </button>
      </div>

      <div class="left-nav-channel-section">
        <div class="left-nav-channel-title">OPEN CHAT</div>
        <div class="left-nav-channel-empty">Get started to select<br>a channel</div>
        <div id="open_channel_list"></div>

        <div class="left-nav-channel-title title-messaging">1ON1 & GROUP CHAT</div>
        <div id="messaging_channel_list"></div>
      </div>

      <div class="left-nav-user">
        <div class="left-nav-user left-nav-user-icon"></div>
        <div class="left-nav-user left-nav-login-user">
          <div class="left-nav-user left-nav-user-title">username</div>
          <div class="left-nav-user left-nav-user-nickname"></div>
        </div>
      </div>

    </div> <!-- // end left nav -->


    <!-- chat section -->
    <div class="right-section">
      <!-- modal-bg -->
      <div class="right-section__modal-bg"></div>

      <!-- top -->
      <div class="chat-top">
        <div class="chat-top__title"></div>
        <div class="chat-top-button">

          <div class="chat-top__button chat-top__button-invite">INVITE</div>
          <div class="modal-guide-user">
            user list
          </div>

          <div class="chat-top__button chat-top__button-member"></div>
          <div class="modal-guide-member">
            Current member list
          </div>

          <div class="chat-top__button chat-top__button-leave"></div>
          <div class="modal-guide-leave">
            Leave
          </div>

        </div>
      </div>

      <!-- channel empty -->
      <div class="chat-empty">
        <div class="chat-empty chat-empty__tile">WELCOME TO PINGIT CHAT</div>
        <div class="chat-empty chat-empty__icon"></div>
        <div class="chat-empty chat-empty__desc">
          Users will engage in chat if they require assistance<br>
          <!--If you don't have a channel to participate,<br>
          go ahead and create your first channel now.-->
        </div>
      </div>

      <!-- chat -->
      <div class="chat">
        <div class="chat-canvas"></div>

        <div class="chat-input">
          <label class="chat-input-file" for="chat_file_input">
            <input type="file" name="file" id="chat_file_input" style="display: none;">
          </label>
          <div class="chat-input-text">
            <textarea class="chat-input-text__field" placeholder="Write a chat" disabled="true"></textarea>
          </div>
        </div>
        <label class="chat-input-typing"></label>
      </div>

    </div> <!-- // end chat section -->

  </div>

  <div class="modal-open-chat">
    <div class="modal-open-chat-top">
      <input type="text" class="modal-open-chat-top__search" placeholder="Search Channel" id="modal_open_chat_search">
    </div>
    <div class="modal-open-chat-list"></div>
    <div class="modal-open-chat-more">
      <div class="modal-open-chat-more__text">MORE<div class="modal-open-chat-more__icon"></div></div>
    </div>
  </div>

  <div class="modal-messaging">
    <div class="modal-messaging-top">
      <label class="modal-messaging-top__title">1on1 Chat</label>
      <label class="modal-messaging-top__desc">Member list shows people inside the application.</label>
    </div>
    <div class="modal-messaging-list">
      <div class="modal-messaging-list__item">Username1<div class="modal-messaging-list__icon"></div></div>
      <div class="modal-messaging-list__item">Username2<div class="modal-messaging-list__icon modal-messaging-list__icon--select"></div></div>

      <div class="modal-messaging-more">MORE<div class="modal-messaging-more__icon"></div></div>
    </div>
    <div class="modal-messaging-bottom">
      <button type="button" class="modal-messaging-bottom__button" onclick="startMessaging()">START MESSAGE</button>
    </div>
  </div>

  <div class="modal-member">
    <div class="modal-member-title">CURRENT MEMBER LIST</div>
    <div class="modal-member-list"></div>
  </div>

  <div class="modal-invite">
    <div class="modal-invite-title">USER LIST</div>
    <div class="modal-invite-top">
      <label class="modal-messaging-top__title modal-invite-top__title">1on1 Chat</label>
      <label class="modal-invite-top__desc">Member list shows people inside the application.</label>
    </div>
    <div class="modal-messaging-list modal-invite-list">

    </div>
    <div class="modal-invite-bottom">
      <button type="button" class="modal-invite-bottom__button" onclick="inviteMember()">INVITE</button>
    </div>
  </div>

  <div class="modal-leave-channel">
    <div class="modal-leave-channel-card">
      <div class="modal-leave-channel-title">Are you Sure?</div>
      <div class="modal-leave-channel-desc">Do you want to leave this channel?</div>
      <div class="modal-leave-channel-separator"></div>
      <div class="modal-leave-channel-bottom">
        <button type="button" class="modal-leave-channel-button modal-leave-channel-close">CANCEL</button>
        <button type="button" class="modal-leave-channel-button modal-leave-channel-submit">YES</button>
      </div>
    </div>
  </div>
  <!-----------------------
        // END modal
  ------------------------>

  <script src="static/lib/SendBird.min.js"></script>
  <script src="static/js/jquery-1.11.3.min.js"></script>
  <script src="static/js/util.js"></script>
  <script src="static/js/chat.js"></script>

</body>
</html>
