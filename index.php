<?php
// Start the session
session_start();

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
                        echo "<li><a id='loginUser' href='#'>Login</a></li>";
                    }
                    else {
                        echo "<li>"+$_SESSION["username"]+"</li>";
                        echo "<li><a id='logoutUser' href='#'>Logout</a></li>";
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
        <?php if(!isset($_SESSION["username"])) : ?>
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
            </div>
        </div>
        <!-- /.row -->
        <?php endif; ?>

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="js/pingIT.js"></script>

</body>

</html>
