<?php

require_once("login/session.php");
	if(isset($_SESSION['user_session'])){
        
    require_once("login/class.user.php");

	require_once("login/session.php");
    $auth_user = new USER();
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
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

    <title><?php if(isset($_SESSION['user_session'])){ print($userRow['user_name']);}else {print ("Welcome!");} ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/player-rater.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
    <!--Accordion CSS CDN -->
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="brand">Player Rater</div>
    <div class="address-bar">ESPN Fantasy Football | Owner Database</div>

    <!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="index.html">The L.E.G</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="league.php">League</a>
                    </li>
                    <li>
                        <a href="blog.php">Blog</a>
                    </li>
                    <li  class="active">
                         <a href="league-submission.php">Submission</a>
                    </li>
                   <li <?php if(isset($_SESSION['user_session'])){
                        echo 'class="hidden"';
                        }; ?>>
                       
                        <a href="login/index.php">Log In</a>
                    </li>
                    <!------------------ log in identifier -------------->
                   <?php if(isset($_SESSION['user_session'])){; ?>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                      <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php  echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile
                            </a>
                          </li>
                          <li>
                            <a href="login/logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out
                            </a>
                          </li>
             <!--------- login in identifier ------------>
                      </ul>
                  </li>
                  <?php }; ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">

        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h1 class="text-center">How to Submit your league to the database by
                       Following these easy steps
                    </h1>
                    
                    <hr>
                    <p>At this point in development, all added leagues and league members are added through submitting your league id and league info.  </p>
                    <p>As the ESPN API is no longer available to the public, we are working a method to delegate the submission process through ESPN log in credentials </p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <h2 class="intro-text text-center">Start Here</h2>
                    <div id="accordion">
            <h3>Step 1</h3>
              <div>
                <p>
                    Go to <a href="http://www.espn.com/" target="_blank">http://www.espn.com/</a>. Locate the Log in Icon, in the upper right-hand corner.
                </p>
                   <img src="img/step1.PNG" alt="Step 1">
              </div>
              <h3>Step 2</h3>
                  <div>
                    <p>
                        Enter your ESPN log in credentials to access your account homepage
                    </p>
                      <img src="img/step2.PNG" alt="Step 2">
                  </div>
              <h3>Step 3</h3>
                  <div>
                    <p>
                        Click the Fantasy Dropdown menu located in the upper right-hand corner as shown in the image below. Select the league you wish to submit to the database
                    </p>
                      <img src="img/step3.PNG" alt="Step 3">
                  </div>
              <h3>Step 4</h3>
                  <div>
                    <p>
                        Locate the league id number embedded into the url bar, atop the browser window. Enter that league id into the submission form below. 
                    </p>
                       <img src="img/step4.PNG" alt="Step 4">
                  </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">Submission
                        <strong>form</strong>
                    </h2>
                    <hr>
                    <p>Fill out the form below to submit your league information in accordance to the guide lines outlined in the Home page section under League Submission. The amount of time before the league gets input into the database varies, as there has been a large influx of potential leagues </p>
                    <form role="form">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>Name(*Optional)</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>League Name (*Optional)</label>
                                <input type="email" class="form-control">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>League ID</label>
                                <input type="tel" class="form-control">
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-lg-12">
                                <label>Message</label>
                                <textarea class="form-control" rows="6" placeholder="Any comments can go here, or you can copy and paste your clubhouse URL into this text area"></textarea>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="hidden" name="save" value="contact">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; League of Extrordinary Genitals 2016</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script>
    $( function() {
        $( "#accordion" ).accordion({
            active: false,
        collapsible: true
        });
    } );
  </script>

</body>

</html>
