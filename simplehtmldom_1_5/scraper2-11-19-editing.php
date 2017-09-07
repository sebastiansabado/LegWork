<?php 
 include('simple_html_dom.php');
require_once('../login/class.user.php');

$seasons = array();
for($i = 2015; $i > 2008; $i--){
$html = file_get_html("http://games.espn.com/ffl/tools/finalstandings?leagueId=347987&seasonId=$i#");
 //Test getElementById 
$table = $html->getElementById('#finalRankingsTable');
$rowData= array();
/*var_dump($table);*/
foreach($table->find('tr') as $row ){
  
  $flight = array();
 
  foreach($row->find('td') as $cell){
        
      foreach($cell->find('a') as $anchor){
          if ($anchor->hasAttribute('href')){
              $url = $anchor->getAttribute('href');
              $pattern = '/^.*?leagueId=(\d+)|teamId=(\d+).*$/';
              //league Id selector  
              preg_match_all($pattern, $url, $team_id);
              //put the team_id into the end flight array
                 foreach($team_id as $id){
                    $flight[]= $id;
                  }
              }
            }
    $flight[]= $cell->plaintext;
     
        }
  //pushes each TR into the array 
  $flight[] = $i;
  if (isset($flight[7])){
  $record_explode = explode("-",$flight[7]);
  foreach ($record_explode as $record){
    $flight[]= $record;
      /*if (!isset($flight[16])){
        $flight[]=0;
      }*/
    }
  }
  $rowData[] = $flight;
  
    }
  //clear first two rows of espn table headings
  unset( $rowData[0], $rowData[1] );
  //reindex $rowData arrays
  $rowData = array_values($rowData);
  //clear empty values and unwanted $matches from regex
  for ($j = 0; $j < 11; $j++){
  unset($rowData[$j][1],
          $rowData[$j][2][1],
          $rowData[$j][3][0],
          $rowData[$j][6]
         );
    }
    //Figure out how to reindex array of arrays
  $seasons[$i]= $rowData;
  }
//use USER CLASS DB CONSTRUCT TO MAKE CONNECTION
$statInsert = new USER();

foreach($seasons as $season){
  echo "enter season loop<br>";
    for($s = 0; $s < 10; $s++){
        echo "$s this is a season<br>"; //ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
        $season_id = $season[$s][13];
        $rank = $season[$s][0];
        $league_id = $season[$s][2][0];
        $team_id = $season[$s][3][1];
        $team_name = $season[$s][4];
        $owner_name = $season[$s][5];
        $wins = $season[$s][14];
        $loses = $season[$s][15];
          if(isset($season[$s][16])){
              $tie = $season[$s][16];
          }else{$tie = 0;}
        $points_forced = $season[$s][8];
        $points_allowed = $season[$s][9];
        $points_forced_per_game = $season[$s][10];
        $points_allowed_per_game = $season[$s][11];
        $difference = $season[$s][12];
          echo "$tie this is a tie<br>";        //dddddddddddddddddddddddddddddddddddddddddddddddddddddd 
                $query1  = 'INSERT INTO owners
                            (team_id, league_id, season_id, owner_name)
                            VALUES
                            (:team_id, :league_id, :season_id, :owner_name)';
        
        $duplicateQuery1 = 'SELECT league_id, team_id, season_id
                            FROM owners
                            WHERE league_id = :league_id AND team_id = :team_id AND season_id = :season_id'; 
        
                 $query2 =  'INSERT INTO season
                            (season_id, league_id)
                            VALUES
                            (:season_id, :league_id)';
        
        $duplicateQuery2 = 'SELECT season_id, league_id
                            FROM season
                            WHERE season_id = :season_id AND league_id = :league_id';
        
                $query3  =  'INSERT INTO stats
                            (team_id, league_id, season_id, rank, team_name, owner_name, wins, loses, tie, points_forced, points_allowed, points_forced_per_game, points_allowed_per_game, difference)
                            VALUES
                            (:team_id, :league_id, :season_id, :rank, :team_name, :owner_name, :wins, :loses, :tie, :points_forced, :points_allowed, :points_forced_per_game, :points_allowed_per_game, :difference)';
        
        $duplicateQuery3 = 'SELECT team_id, league_id, season_id, rank, team_name, owner_name, wins, loses, tie, points_forced, points_allowed,                       points_forced_per_game, points_allowed_per_game, difference
                            FROM stats
                            WHERE team_id = :team_id AND league_id = :league_id  AND season_id =  :season_id AND rank = :rank AND team_name = :team_name AND owner_name = :owner_name AND wins = :wins AND loses = :loses AND tie = :tie AND points_forced = :points_forced AND points_allowed = :points_allowed AND points_forced_per_game = :points_forced_per_game AND points_allowed_per_game = :points_allowed_per_game AND difference = :difference';
                $query4 =  'INSERT INTO leauge
                            (league_id)
                            VALUES 
                            (:league_id)';
        $duplicateQuery4 = 'SELECT league_id
                            FROM league
                            WHERE league_id = :league_id';
        try{
          $stmt = $statInsert->runQuery($duplicateQuery1);
          $stmt->bindValue(':team_id', $team_id);
          $stmt->bindValue(':league_id', $league_id);
          $stmt->bindValue(':season_id', $season_id);
          $stmt->execute();
          $stmt->closeCursor();

            if($stmt->rowCount() == 0){
                try{
                  $stmt = $statInsert->runQuery($query1);
                  $stmt->bindValue(':team_id', $team_id);
                  $stmt->bindValue(':league_id', $league_id);
                  $stmt->bindValue(':owner_name', $owner_name);
                  $stmt->bindValue(':season_id', $season_id);
                  $success1 = $stmt->execute();
                  $stmt->closeCursor();
                    } catch (PDOException $e){
                        $error_message = $e->getMessage();
                        echo "$error_message";
                      }
               if($success1){
                   //checks the database for duplicate season table entries
                 try{
                      $stmt2 = $statInsert->runQuery($duplicateQuery2);
                      $stmt2->bindValue(':season_id', $season_id);
                      $stmt2->bindValue(':league_id', $league_id);
                      $stmt2->execute();
                      $stmt2->closeCursor();
                        } catch (PDOException $e){
                            $error_message = $e->getMessage();
                            echo "$error_message";
                          }
                   //comment toggle
                   if($stmt2->rowCount() == 0){
                        echo "row count not 0<br>";
                  try{
                      echo "inserting season data<br>";
                      $stmt2 = $statInsert->runQuery($query2);
                      $stmt2->bindValue(':season_id', $season_id);
                      $stmt2->bindValue(':league_id', $league_id);
                      $success2 = $stmt2->execute();
                      $stmt2->closeCursor();
                        } catch (PDOException $e){
                            $error_message = $e->getMessage();
                            echo "$error_message yooo <br>";
                          }
                      }
                   if($success2){
                       try{
                      $stmt3 = $statInsert->runQuery($duplicateQuery3);
                      $stmt3->bindValue(':team_id', $team_id);
                      $stmt3->bindValue(':league_id', $league_id);
                      $stmt3->bindValue(':season_id', $season_id);
                      $stmt3->bindValue(':rank', $rank);
                      $stmt3->bindValue(':team_name', $team_name);
                      $stmt3->bindValue(':owner_name', $owner_name);
                      $stmt3->bindValue(':wins', $wins);
                      $stmt3->bindValue(':loses', $loses);
                      $stmt3->bindValue(':tie', $tie);
                      $stmt3->bindValue(':points_forced', $points_forced);
                      $stmt3->bindValue(':points_allowed', $points_allowed);
                      $stmt3->bindValue(':points_forced_per_game', $points_forced_per_game);
                      $stmt3->bindValue(':points_allowed_per_game', $points_allowed_per_game);
                      $stmt3->bindValue(':difference', $difference);
                      $stmt3->execute();
                           echo "entering stats<br>";
                      $stmt3->closeCursor();
                        } catch (PDOException $e){
                            $error_message = $e->getMessage();
                            echo "$error_message";
                          }
                       if($stmt3->rowCount() == 0){
                         echo "entering stat data";
                             try{
                              $stmt3 = $statInsert->runQuery($query3);
                              $stmt3->bindValue(':team_id', $team_id);
                              $stmt3->bindValue(':league_id', $league_id);
                              $stmt3->bindValue(':season_id', $season_id);
                              $stmt3->bindValue(':rank', $rank);
                              $stmt3->bindValue(':team_name', $team_name);
                              $stmt3->bindValue(':owner_name', $owner_name);
                              $stmt3->bindValue(':wins', $wins);
                              $stmt3->bindValue(':loses', $loses);
                              $stmt3->bindValue(':tie', $tie);
                              $stmt3->bindValue(':points_forced', $points_forced);
                              $stmt3->bindValue(':points_allowed', $points_allowed);
                              $stmt3->bindValue(':points_forced_per_game', $points_forced_per_game);
                              $stmt3->bindValue(':points_allowed_per_game', $points_allowed_per_game);
                              $stmt3->bindValue(':difference', $difference);
                              $success3 = $stmt3->execute();
                              $stmt3->closeCursor();
                                } catch (PDOException $e){
                                    $error_message = $e->getMessage();
                                    echo "$error_message";
                                  }
                         try {
                           $stmt4 = $statInsert->runQuery($duplicateQuery4);
                           $stmt4->bindValue(':league_id', $league_id);
                           $stmt4->execute();
                           $stmt4->closeCursor();
                         } catch (PDOException $e){
                                    $error_message = $e->getMessage();
                                    echo "$error_message";
                                  }
                         if($stmt4->rowCount() == 0){
                           echo "entering league data";
                             try{
                                 $stmt4 = $statInsert->runQuery($duplicateQuery4);
                                 $stmt4->bindValue(':league_id', $league_id);
                                 $stmt4->execute();
                                 $stmt4->closeCursor();
                             } catch (PDOException $e){
                                    $error_message = $e->getMessage();
                                    echo "$error_message";
                                  }
                         }
                    //third if statement
                        }
                      }  
                  //second if statment
                       //comment toggle
                    
                  }
              //first if statement
                }
          //first try statement
            }catch (PDOException $e){
                        $error_message = $e->getMessage();
                        echo "$error_message";
                      }
        //for loop
          }
    //foreach loop
      }
/* if($success3){
          echo "Congratulations  you inserted all the stats correctly!";
        }*/

var_dump($seasons[2014]);
?>