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

// [!] Set session storage
ParseClient::setStorage( new ParseSessionStorage() );

$loginError = FALSE;
$regError = FALSE;

if(isset($_COOKIE["loginError"])) {
    setcookie("loginError","",1);
    $loginError = TRUE;
}

if(isset($_COOKIE["regError"])) {
    setcookie("regError","",1);
    $regError = TRUE;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PingIT</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
                <a class="navbar-brand" href="#">PingIT</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <!--<li>
                        <a href="#">About</a>
                    </li>-->
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

    <!-- Page Content -->
    <div class="container">
        <?php if(isset($_SESSION["username"])) : ?>
        <!--<div class="row">
            <div class="col-lg-12 text-center">
                <h1>The start of PingIT: IT HAS BEGUN</h1>
                <p class="lead">And it has STUFF! <?php if(isset($_COOKIE["Posted"])){echo "<br/> This was posted: ".$_COOKIE["Posted"]; setcookie("Posted","",1);}  else {echo "<br/> Non email";}?></p>
            </div>
        </div>-->
        <!-- /.row -->
        
        <div class="row">
            <div class="col-lg-1"></div>
            
             <div class="col-lg-4">
                <form id="formNotify" action="notify.php" method="post" class="form-horizontal">
                    <fieldset>
                        <legend>Notification</legend>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="inputEmail" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="messageArea" class="col-lg-2 control-label">Message</label>
                            <div class="col-lg-10">
                                <textarea name="message" class="form-control" rows="3" id="messageArea">Your computer is ready for pickup.</textarea>
                                <!--<span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                            </div>
                        </div>
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-primary">Notify</button>
                        </div>
                    </fieldset>
                </form>
                <br/>
                <form id="announceForm" action="announce.php" method="post" class="form-horizontal">
                    <fieldset>
                        <legend>Announcement</legend>
                        <div class="form-group">
                            <label for="announceArea" class="col-lg-2 control-label">Message</label>
                            <div class="col-lg-10">
                                <textarea name="annouce" class="form-control" rows="3" id="announceArea" placeholder="Annoucement to all users"></textarea>
                                <!--<span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                            </div>
                        </div>
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-primary">Announce</button>
                        </div>
                    </fieldset>
                </form>
                <br/>
                <form id="categoryForm" action="announce.php" method="post" class="form-horizontal">
                    <fieldset>
                        <legend>Category</legend>
                        <div class="form-group">
                            <!--<label for="inputCategory" class="col-lg-2 control-label"></label>-->
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="inputCategory" placeholder="New Category">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <br/>
                <form id="categoryRmForm" action="announce.php" method="post" class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <!--<label for="inputCategory" class="col-lg-2 control-label"></label>-->
                            <div class="col-lg-10">
                                <select class="form-control" id="selectCategory">
                                    <option selected></option>
                                    <option>1: Should be PHP</option>
                                    <option>2: Definitely PHP</option>
                                    <option>3: Whatever</option>
                                </select>
                                <button type="submit" id="rmCatButton" class="btn btn-danger">Remove</button>
                                <button type="reset" id="cnlCatButton" class="btn btn-primary hidden">Cancel</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
                
            </div>
            <div class="col-lg-6">
                <form action="faq.php" method="post" class="form-horizontal">
                    <fieldset>
                        <legend>Questions and Answers</legend>
                        <div class="half-width">
                            <div class="form-group">
                                <label for="inputQuestion" class="col-lg-2 control-label">Q:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputQuestion" placeholder="Question">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="answerArea" class="col-lg-2 control-label">A:</label>
                                <div class="col-lg-10">
                                    <textarea name="answer" class="form-control" rows="3" id="answerArea" placeholder="Answer"></textarea>
                                    <!--<span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                                </div>
                            </div>
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="reset" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-primary">Add Q&A</button>
                            </div>
                        </div>
                        <div class="half-width"></div>
                        
                    </fieldset>
                </form>
                <br/>
                <div id="faqBox" class="well">
                    <?php include "faqPartial.php"; ?>
                </div>
            </div>
        </div>
        <!-- /.row -->
        
        <?php else : ?>
        <div class="row">
             <div class="col-lg-12 text-center">
                <h1>Please login to use PingIT web interface</h1>
                <?php if(isset($_COOKIE["Test"])) { echo "<b>".$_COOKIE["Test"]."</b>"; } ?>
            </div>
        </div>
        <!-- /.row -->
        <?php endif; ?>

    </div>
    <!-- /.container -->
    
    <?php if(!isset($_SESSION["username"])) : ?>
    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" action="login.php" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="loginModalLabel">Login</h4>
                        <?php if($loginError) { echo "<b style='color: red;'>Incorrect login details</b>"; } ?>
                    </div>
                    <div class="modal-body">
                        <fieldset>
                            <div class="form-group <?php if($loginError){ echo "has-error"; } ?>">
                                <label for="loginName" class="col-lg-2 control-label">Username</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="loginName" name="username">
                                </div>
                            </div>
                            <div class="form-group <?php if($loginError){ echo "has-error"; } ?>">
                                <label for="loginPass" class="col-lg-2 control-label">Password</label>
                                <div class="col-lg-8">
                                    <input type="password" class="form-control" id="loginPass" name="password">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" action="register.php" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="loginModalLabel">Register</h4>
                        <?php if($regError) { echo "<b style='color: red;'>Incorrect login details</b>"; } ?>
                    </div>
                    <div class="modal-body">
                        <fieldset>
                            <div class="form-group <?php if($regError){ echo "has-error"; } ?>">
                                <label for="regName" class="col-lg-2 control-label">Username</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="regName" name="username">
                                </div>
                            </div>
                            <div class="form-group <?php if($regError){ echo "has-error"; } ?>">
                                <label for="regPass" class="col-lg-2 control-label">Password</label>
                                <div class="col-lg-8">
                                    <input type="password" class="form-control" id="regPass" name="password">
                                </div>
                            </div>
                            <div id="passConfirm" class="form-group <?php if($loginError){ echo "has-error"; } ?>">
                                <label for="confPass" class="col-lg-2 control-label">Confirm</label>
                                <div class="col-lg-8">
                                    <input type="password" class="form-control" id="confPass" name="confPass">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?php endif; ?>

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="js/pingIT.js"></script>
    
               
    <?php if($loginError) : ?>
    
    <script type="text/javascript">
    $(document).ready(function() {
        $("#loginModal").modal('show');
    })
    </script>
    
    <?php endif; ?>
    
    <?php if(!isset($_SESSION["username"])) : ?>
    
    <script type="text/javascript">
    $(document).ready(function() {
        $('#confPass').on('keyup', function () {
            if ($(this).val() == $('#regPass').val()) {
                $('#passConfirm').addClass('has-success');
                $('#passConfirm').removeClass('has-error');
            } else  {
                $('#passConfirm').removeClass('has-success');
                $('#passConfirm').addClass('has-error');
            }
        });
    });
    </script>
    
    <?php endif; ?>

</body>

</html>
