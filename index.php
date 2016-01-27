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
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
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
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>The start of PingIT: IT HAS BEGUN</h1>
                <p class="lead">And it has STUFF!                <?php if(isset($_COOKIE["Posted"])){echo "<br/> This was posted: ".$_COOKIE["Posted"]; setcookie("Posted","",1);}  else {echo "<br/> Non email";}?></p>
                <!--<ul class="list-unstyled">
                    <li>Bootstrap v3.3.6</li>
                    <li>jQuery v1.11.1</li>
                </ul>-->
            </div>
        </div>
        <!-- /.row -->
        
        <div class="row">
            <div class="col-lg-2"></div>
            
             <div class="col-lg-3">
                <form action="notify.php" method="post">
                    <fieldset>
                        <h3>Notification</h3>
                        <label>Email</label><br/>
                        <input name="email" placeholder="EX: email@domain.com" type="email"/>
                        <br/>
                        <label>Message</label><br/>
                        <textarea name="message" style="max-width: 100%">Your computer is ready for pickup</textarea>
                        <br/>
                        <button type="submit" class="btn btn-primary">Notify</button>
                    </fieldset>
                </form>
            </div>
            <div class="col-lg-2"></div>
            <div id="faqBox" class="col-lg-4 text-center well">
                <form action="faq.php" method="post">
                    <label>Question</label><br/>
                    <input name="question" placeholder="Question to ask"/>
                    <br/>
                    <label>Answer</label><br/>
                    <input name="answer" placeholder="Answer to question"/>
                    <br/>
                    <button type="submit" class="btn btn-primary">Add Q&A</button>
                </form>
            </div>
        </div>
        <!-- /.row -->
        
        <div class="row">
            <div class="col-lg-2"></div>
            
             <div class="col-lg-3">
                <form action="notify.php" method="post">
                    <fieldset>
                        <h3>Announcement</h3>
                        <label>Message</label><br/>
                        <textarea name="message" style="max-width: 100%">Your computer is ready for pickup</textarea>
                        <br/>
                        <button type="submit" class="btn btn-primary">Notify</button>
                    </fieldset>
                </form>
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
