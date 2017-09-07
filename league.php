<?php

	require_once("login/session.php");
    require_once("login/class.user.php");
	if(isset($_SESSION['user_session'])){
        
      
    $auth_user = new USER();
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    };
//GENERATE LEAGUE POPULATION FOR FORM
    $leagueTable = new USER;
    $stmt = $leagueTable->runQuery("SELECT league_id FROM league");
    $stmt->execute();
    $leagues = $stmt->fetchAll();
    $stmt->closeCursor();
    
    $league_info = new USER;
    $league_id = filter_input(INPUT_POST, 'selected_league_id');
//QUERIES FOR TABLES


    $stmt = $league_info->runQuery("SELECT DISTINCT a.owner_name, a.team_name FROM stats as a 
              WHERE league_id = :league_id");
    $stmt->bindValue(':league_id', $league_id);
    $stmt->execute();
    $results =$stmt->fetchAll();
    $stmt->closeCursor();

//Get selected league year with league_id
  $league_years = new USER;
  $stmt = $league_years->runQuery("SELECT season_id
                                  FROM season 
                                  WHERE league_id = :league_id");
  $stmt->bindValue(':league_id', $league_id);
  $stmt->execute();
  $years = $stmt->fetchAll();
  $stmt->closeCursor();

 /* $league_season_stats = new USER;*/
 /* $season_id = filter_input(INPUT_GET, 'selected_season_id');*/
  
  /*$stmt = $league_season_stats->runQuery("SELECT * FROM stats
                                          WHERE league_id = :league_id AND season_id = :season_id");
  $stmt->bindValue(':league_id', $league_id);
  $stmt->bindValue(':season_id', $season_id);
  $stmt->execute();
  $season_stats = $stmt->fetchAll();
  $stmt->closeCursor();*/
  
/*    $ownerInfo = new USER;
    $results = $ownerInfo->get_owner_info($league_id);*/
    
//GET SELECTED LEAGUE ID FROM FORM
   /* $league_id = filter_input(INPUT_POST, 'leagued_id', FILTER_VALIDATE_INT);
        if($league_id == NULL){
          $league_id = 347987;
        }
    $selectedLeague = 'SELECT * FROM :league_year'
 //GET SELECTED YEAR FOR LEAGUE
      $year = filter_input(INPUT_POST,'year', FILTER_VALIDATE_INT);
      if($year == NULL){
        $year = 2015;
      }*/
  /*var_dump($results);*/
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
  <!--<script src="jquery-3.1.1.min.js"></script>-->
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet">
   
    <!-- Custom CSS -->
    <link href="css/player-rater.css" rel="stylesheet">
    
   
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
  
  <!-- jQuery -->
    <script src="js/jquery.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
   <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
    
<!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js">
    </script>
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
                <a class="navbar-brand" href="index.html">the l.e.g</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                 <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li  class="active">
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
                      <span class="glyphicon glyphicon-user"></span>&nbsp;Hello <?php  echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
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
                    <h2 class="intro-text text-center">
                        <strong>Leagues</strong>
                    </h2>
                        <div class="form-group">
                           <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                             <label name="selected_league_id_header">Select League ID</label>
                               <select class="form-control" name="selected_league_id" id="selected_league_id">
                                 <option value="">Select league</option>
                              <?php foreach ($leagues as $league) : ?>
                              <option value="<?php echo $league['league_id'] ?>"><?php echo $league['league_id'] ?></option>                     
                              <?php endforeach; ?>
                                </select>
                             <input type="submit" name="league" class="btn btn-info pull-right" value="Enter">
                          </form>
                  </div>                   
                   <div> 
                       <?php if(isset($league_id)){ ?>
                       <h3>League Members for League: <?php echo  $league_id; ?></h3>
                                   
                <table class="table table-striped table-bordered dt-responsive" id="ownerTable">
                    <thead>
                      <tr>
                        <th>Owner Name</th>
                        <th>Team Name</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($results as $result) :?>
                      <tr>
                      <td><?php echo $result['owner_name']; ?></td>
                      <td><?php echo $result['team_name']; ?></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
               </table>
                       <?php }; ?>
              </div>
                    <hr>
                </div>
                <div class="col-md-6">
                    <img class="img-responsive img-border-left" src="img/slide-2.jpg" alt="">
                </div>
                <div class="col-md-6">
                    <p>League information  and details and  </p>
                    <p>Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis omnis fugats vitaes nemo minima rerums unsers sadips amets.</p>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">League
                        <strong>Standings For League ID : <?php echo $league_id; ?></strong>
                    </h2>
                       <div class="form-group">
                              <label>Select League Year</label>
                                    <select class="form-control" id="selected_season_id">
                                      <option value="" >Select League Year</option>
                                        <?php foreach ($years as $year) : ?>
                                        <option value="<?php echo $year['season_id']; ?>"><?php echo $year['season_id']; ?></option>        
                                        <?php endforeach; ?>
                                      </select>          
                      </div>
                  <div class="table-responsive" id="season_stats_table">         
              </div>
                    <hr>
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
                    <p>Copyright &copy; League of Extrordinary Genitals 2016</p>
                </div>
            </div>
        </div>
    </footer>
    <script>      
            $('#selected_season_id').change(function(){
               var season_id = this.value;
               var league_id = <?php echo $league_id; ?>;
               
           
            //if(season_id){
            $.ajax({
            type: "GET",
            url: "ajax.php?season_id="+season_id+"&league_id="+league_id,
            success: function(response){
            $('#season_stats_table').html(response);
            }
            });
            });
           
        
</script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable();
            });
    </script>
</body>

</html>
