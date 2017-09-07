<?php
require_once("login/session.php");
    
	if(isset($_SESSION['user_session'])){
        
    require_once("login/class.user.php");

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
                <a class="navbar-brand" href="index.html">THE L.E.G</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="league.php">League</a>
                    </li>
                    <li>
                        <a href="blog.php">Blog</a>
                    </li>
                    <li>
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
        
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">

        <div class="row">
            <div class="box">
                <div class="col-lg-12 text-center">
                    <div id="carousel-example-generic" class="carousel slide">
                        <!-- Indicators -->
                        <ol class="carousel-indicators hidden-xs">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img class="img-responsive img-full" src="img/slide-1.jpg" alt="">
                            </div>
                            <div class="item">
                                <img class="img-responsive img-full" src="img/slide-2.jpg" alt="">
                            </div>
                            <div class="item">
                                <img class="img-responsive img-full" src="img/slide-3.jpg" alt="">
                            </div>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="icon-prev"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="icon-next"></span>
                        </a>
                    </div>
                    <h2 class="brand-before">
                        <small>Welcome to</small>
                    </h2>
                    <h1 class="brand-name">Fatnasy Owner Rater</h1>
                    <hr class="tagline-divider">
                    <h2>
                        <small>By
                            <strong>The L.E.G</strong>
                        </small>
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">Welcome to the first fantasy owner  
                        <strong>Database</strong>
                    </h2>
                    <hr>               
                    <hr class="visible-xs">
 
                    <div class="col-lg-4">
                    	<h3 class="text-center">Purpose:</h3>
	                    <p>The purpose of this website is to have a centralized location for collected statistics of fantasy owners. This site is in constant construction, refining methods to abstracting meaningful statistics from compiled data of fantasy owner seasons.</p>
                    </div>
                   
                    <div class="col-lg-4">
                    	<h3  class="text-center">Problem:</h3>
                    <p>A big problem faced with fantasy football players is the constant revolving door of members. Why not choose the best of the best, by browsing through the history of potential candidates to fill those hole in the league roster. With this database you will be able to see concrete numbers of potential league members. </p>
                    </div>
                    <div class="col-lg-4">
                    	<h3 class="text-center">Solution:</h3>
                    <p>This site includes various stats, from wins, loses, points scored, points forced and many more. Our key aim is to quantify the effort a person puts into their league, to better gauge their value as a member of your own league. The end goal will be to summarize individual team statistics and find meaning in how a member performs. </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">Information for
                        <strong>The L.E.G</strong>
                    </h2>
                    <hr>
                </div>
                <div class="col-md-8">
                    <!-- Embedded Google Map using an iframe - to select your location find it on Google maps and paste the link as the iframe src. If you want to use the Google Maps API instead then have at it! -->
                    <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=37.0625,-95.677068&amp;spn=56.506174,79.013672&amp;t=m&amp;z=4&amp;output=embed"></iframe>
                </div>
                <div class="col-md-4">
                    <p>Phone:
                        <strong>123.456.7890</strong>
                    </p>
                    <p>Email:
                        <strong><a href="mailto:name@example.com">SebastianSabado2@yahoo.com</a></strong>
                    </p>
                    <p>Address:
                        <strong>3481 Melrose 
                            <br>Beverly Hills, CA 90210</strong>
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>   

    </div>
    <!-- /.container -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy;League of Extrordinary Genitals 2016</p>
                </div>
            </div>
        </div>
    </footer>
     <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>
     
</body>

</html>
