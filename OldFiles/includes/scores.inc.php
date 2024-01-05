<?php
/**
 * WMIPL Statistics Calculator
 *
 * This script retrieves shooter, team, division, and score information from
 * a MySQL database, calculates various statistics, and provides organized
 * data for rendering in HTML format. It serves as the backend logic for
 * generating statistical reports and displays in a Shooting League
 * web application.
 */
// Include the database helper
require 'dbh.inc.php';

// SECTION: Retrieve Shooter Information (need current shooters regardless of whether or not they have a score this season)
// Initialize an empty array for divisions
$divisions = array();

// Retrieve data from the database for all current season shooters and scores
$result = $conn->query("CALL current_roster()");

// Iterate through the results
while($row = $result->fetch(PDO::FETCH_ASSOC) ){
    // Check if divisions array is empty
    if(!$divisions){
        // Create a multidimensional array where shooter and shooter number are within a team, which is within a division
        $divisions = array($row['division']=>array($row['team']=>array($row['number']=>$row['name'])));
    } else {
        // Check if this is a new division
        if(!array_key_exists($row['division'],$divisions)){
            $divisions += array($row['division']=>array($row['team']=>array($row['number']=>$row['name'])));
        } else {
            // Check if this is a new team
            if(!array_key_exists($row['team'], $divisions[$row['division']])){
                $divisions[$row['division']] += array($row['team']=>array($row['number']=>$row['name']));
             // This is another shooter in the current division and current team
            } else {
                $divisions[$row['division']][$row['team']] += array($row['number']=>$row['name']);
            }
        }
    }
}

// Save the divisions array as $roster for the roster display
$roster = $divisions;

// free the result set from the stored procedure calll
$result->closeCursor();

// Uncomment the line below to check your work
// echo json_encode($divisions);

// SECTION: Retrieve Shooter Scores
// Initialize a fresh array for scores
$scores = array();
$division = '';
$team = '';
$shooter = '';
$number = 0;
$qual = array();

// Retrieve the scores for the season and add them to the arrays
$result = $conn->query("CALL current_season()");

// Iterate through the results
while($row = $result->fetch(PDO::FETCH_ASSOC)){
    // Check if this is the first row
    if(!$scores){
        // Create a multidimensional array where the shooter scores are compiled by week
        if(substr($row['wk'],0,1) !='Q'){
            $shooter = $row['name'];
            $division = $row['division'];
            $team = $row['team'];
            $number = $row['number'];
            $scores = array($row['wk']=>array($row['score'],$row['changed']));
        // Qual score -> add it up for LYA
        } else {
            $shooter = $row['name'];
            $division = $row['division'];
            $team = $row['team'];
            $number = $row['number'];
            $qual += $row['score'];
        }
    // Check if this is a new shooter
    } elseif ($shooter != $row['name']){
        // Close up the shooter
        // Verify this is not a new shooter, if so, calculate LYA
        if ($qual){
            $scores += array('lya'=>(array_sum($qual)/count($qual)));
            // Clear the qual
            $qual = array();
        }
        // Put the shooter's scores into the $divisions array
        $divisions[$division][$team][$number] = array($shooter => $scores);
        // Start with a new array
        $scores = array();
        // Add the shooter to the array
        if(substr($row['wk'],0,1) !='Q'){
            $shooter = $row['name'];
            $division = $row['division'];
            $team = $row['team'];
            $number = $row['number'];
            $scores = array($row['wk']=>array($row['score'],$row['changed']));
        // Qual score -> add it up for LYA
    } else {
            $shooter = $row['name'];
            $division = $row['division'];
            $team = $row['team'];
            $number = $row['number'];
            $qual += $row['score'];
        }
    } else {
        // Not a new shooter and not an empty array
        // Add the shooter to the array
        if(substr($row['wk'],0,1) !='Q'){
            $scores += array($row['wk']=>array($row['score'],$row['changed']));
        } else {
            // Qual score -> add it up for LYA
            array_push($qual,$row['score']);
        }
    }
}

// Put the last shooter's scores into the $divisions array
if ($qual){
    $scores += array('lya'=>(array_sum($qual)/count($qual)));
}
$divisions[$division][$team][$number] = array($shooter => $scores);

// Free the result set from the stored procedure
$result->closeCursor();

// Divisions should now have scores attached to each shooter's name
// Uncomment the line below to check your work
// echo json_encode($divisions);

// SECTION: Retrieve LYAs for Returning Shooters
// Start with a fresh array for LYAs
$lyas_arr = array();

// Get LYAs for returning shooters
$result = $conn->query("CALL current_lyas()");
while($row = $result->fetch(PDO::FETCH_ASSOC)){
    $lyas_arr += array($row['name']=>$row['score']);
}
// Uncomment the line below to check your work
// echo json_encode($scores);
// Free the result set from the stored procedure
$result->closeCursor();

// SECTION: Update Divisions with LYAs
// Cycle through the existing divisions and add LYAs to shooters
foreach($divisions as $div => $teams){
    foreach($teams as $team => $numbers){
        foreach($numbers as $number => $shooters){
            // foreach only works if $shooters is an array, which will not be the case pre-week 1 or for anyone who missed the first few weeks
            if(!is_string($shooters)){
                foreach($shooters as $shooter => $data){
                    if(array_key_exists($shooter, $lyas_arr)){
                        $divisions[$div][$team][$number][$shooter] += array('lya'=>$lyas_arr[$shooter]);
                    }
                }
            } else {
                $divisions[$div][$team][$number] = array($shooters => array('lya'=>$lyas_arr[$shooters]));
            }
        }
    }
}

// SECTION: Additional Data Retrieval
// Create a new variable for scores calculations
$match_completed = 0;

// Get the latest match number from the database
$result = $conn->query("CALL match_completed");
$res_arr = $result->fetch(PDO::FETCH_ASSOC);
$match_completed = $res_arr['match_num'];
$result->closeCursor();

// Create a new variable to hold the classes
$classes = array();

// Get the current class breakdown
$result = $conn->query("CALL current_class");
$classes = $result->fetch(PDO::FETCH_ASSOC);
$result->closeCursor();

// Uncomment the lines below to check your work
// echo json_encode($classes);
// echo json_encode($match_completed);
// $divisions should now include all current season divisions, teams, shooters, and scores including last year averages
// echo json_encode($divisions); // Check your work!

// Calculate all of the missing scores
$agg = 0;
foreach($divisions as $div => $teams){
    foreach($teams as $team => $numbers){
        $lyas = 0;
        foreach($numbers as $number => $shooters){
            if(is_numeric($number)){
                $s=0;
                foreach($shooters as $shooter => $scores){
                    $agg = 0;
                    $high = 0;
                    $wks = 0;
                    for($wk=1;$wk< 16;$wk++){
                        if(!array_key_exists($wk,$scores)){
                            if($wk <= $match_completed){
                                $missed_score = round(($agg + $divisions[$div][$team][$number][$shooter]['lya'])/$wk)-10;
                                $divisions[$div][$team][$number][$shooter] += array($wk=>array($missed_score,'0','1'));
                                $agg += $missed_score;
                                if($high < $missed_score){
                                    $high = $missed_score;
                                }
                                $wks++;
                            } else {
                                $divisions[$div][$team][$number][$shooter] += array($wk=>array('0','0','0'));
                            }
                        } else {
                            array_push($divisions[$div][$team][$number][$shooter][$wk],'0');
                            if($high < $scores[$wk][0]){
                                $high = $scores[$wk][0];
                            }
                            $agg += $scores[$wk][0];
                            if($scores[$wk][0] > 0){
                                $wks++;
                            }
                        }
                    }
                    if($scores['lya'] > $classes['A']){
                        $class = 'A';
                    }elseif($scores['lya'] > $classes['B']){
                        $class = 'B';
                    }elseif($scores['lya'] > $classes['C']){
                        $class = 'C';
                    }elseif($scores['lya'] > $classes['D']){
                        $class = 'D';
                    }elseif($scores['lya'] > $classes['E']){
                        $class = 'E';
                    }else{
                        $class = 'F';
                    }
                    $avg = (($agg + $divisions[$div][$team][$number][$shooter]['lya'])/($wks+1));
                    $divisions[$div][$team][$number][$shooter] += array('agg'=>$agg);
                    $divisions[$div][$team][$number][$shooter] += array('avg'=>$avg);
                    $divisions[$div][$team][$number][$shooter] += array('high'=>$high);
                    $divisions[$div][$team][$number][$shooter] += array('class'=>$class);
                    ksort($divisions[$div][$team][$number][$shooter]);
                    $lyas += $scores['lya'];
                }
            }
        }
        $divisions[$div][$team] += array('lyaas'=>$lyas);
    }
}

// add in dummy shooters where appropriate
foreach($divisions as $div => $teams){
    foreach($teams as $team=>$numbers){
        $lyas = $divisions[$div][$team]['lyaas'];

        // Create an array of numbers to test
        $numb_keys = array_keys($numbers);
        
        // Iterate through 6 possible dummy shooters
        for($x=0;$x<6;$x++){
            // Build the test shooter number to see if shooter exists
            $test_num = $numb_keys[0] - ($numb_keys[0]%10) + $x;
            
            // Check to see if shooter exists
            if(!array_key_exists($test_num,$numbers)){
                // Shooter does not exist, get the team's average of lya
                $team_lya = number_format($lyas/(count($divisions[$div][$team])-1),0);
                
                // Create an empty array to hold scores
                $dum_scores = array();
                
                // Create scores for each week
                for($wk=1;$wk<16;$wk++){
                    // Only add scores for weeks that are completed
                    if($wk > $match_completed){
                        $dum_scores += array($wk=>array('0','0','0'));
                    } else {
                        $dum_scores += array($wk=>array($team_lya, '0','0'));
                    }
                }

                // Determine the class of the fake shooter
                if($team_lya > $classes['A']){
                    $class = 'A';
                }elseif($team_lya > $classes['B']){
                    $class = 'B';
                }elseif($team_lya > $classes['C']){
                    $class = 'C';
                }elseif($team_lya > $classes['D']){
                    $class = 'D';
                }elseif($team_lya > $classes['E']){
                    $class = 'E';
                }else{
                    $class = 'F';
                }

                // Add to the score array the necessary statistics
                $dum_scores += array('class'=>$class);
                $dum_scores += array('agg'=>$team_lya*$match_completed);
                $dum_scores += array('avg'=>$team_lya);
                $dum_scores += array('lya'=>$team_lya);
                $dum_scores += array('high'=>$team_lya);
                
                // Push the fake shooter, scores, and statistics to the divisions array
                $divisions[$div][$team] += array($test_num=>array('DUMMY'=>$dum_scores));
                
                // Add the fake shooter's lya to the lyaa for the team
                $lyas += $team_lya;
            }
        }          
        // Replace the team's lyaa with the new one including the fake shooters
        $divisions[$div][$team]['lyaas'] = $lyas;
        
        // Sort it for readability
        ksort($divisions[$div][$team]);
    }
}

// SECTION: Team Statistics Calculation
// Create an array to represent opposing teams
$opp_teams_array = array([2,3,4,2,3,4,2,3,4,2,3,4,2,3,4],[1,4,3,1,4,3,1,4,3,1,4,3,1,4,3],[4,1,2,4,1,2,4,1,2,4,1,2,4,1,2],[3,2,1,3,2,1,3,2,1,3,2,1,3,2,1]);

// Calculate the number of handicap matches
$hand_matches = ($match_completed < 15) ? $match_completed + 2 : $match_completed + 1;

// Create the team statistics and add the opposing teams array to the team
foreach($divisions as $div=>$teams){
    $t = 0;
    foreach($teams as $team => $numbers){
        // Add opposing teams
        $divisions[$div][$team] += array('opp_teams'=>$opp_teams_array[$t]);
        
        // Reset variables for each team
        $team_agg = array();
        $team_agg_agg = 0;
        $team_agg_avg = array();
        $team_hand_avg = array();
        $n = 0;

        foreach($numbers as $number=>$shooters){
            if(is_numeric($number)){
                if($n<6){
                    $w = 1;
                    foreach($shooters as $name => $scores){
                        for($w=1;$w<16;$w++){
                            // Add each member's weekly score to the team agg for the week
                            if(array_key_exists('wk'.$w.'agg',$team_agg)){
                                $team_agg['wk'.$w.'agg'] += $scores[$w][0];
                            } else {
                                $team_agg += array('wk'.$w.'agg'=>$scores[$w][0]);
                            }
                        }
                    }
                    $n++;
                }
            }
        }

        for($y=1;$y<16;$y++){
            // Average the team's weekly aggs over each week of the season and calculate the rolling 3-week handicap average
            if($y<=$match_completed+1){
                if($y==1){
                    $team_agg_agg += $team_agg['wk'.$y.'agg'];
                    $team_agg_avg += array('wk'.$y.'agg_avg' => $team_agg_agg/$y);
                    $team_hand_avg += array('wk'.$y.'hand_avg' => $divisions[$div][$team]['lyaas']);
                }elseif($y == 2){
                    $team_agg_agg += $team_agg['wk'.$y.'agg'];
                    $team_agg_avg += array('wk'.$y.'agg_avg' => $team_agg_agg/$y);
                    $team_hand_avg += array('wk'.$y.'hand_avg' => (($divisions[$div][$team]['lyaas']*2)+$team_agg['wk'.($y-1).'agg'])/3);
                }elseif($y == 3){
                    $team_agg_agg += $team_agg['wk'.$y.'agg'];
                    $team_agg_avg += array('wk'.$y.'agg_avg' => $team_agg_agg/$y);
                    $team_hand_avg += array('wk'.$y.'hand_avg' => ($divisions[$div][$team]['lyaas']+$team_agg['wk'.($y-1).'agg']+$team_agg['wk'.($y-2).'agg'])/3);
                }else{
                    $team_agg_agg += $team_agg['wk'.$y.'agg'];
                    $team_agg_avg += array('wk'.$y.'agg_avg' => $team_agg_agg/$y);
                    $team_hand_avg += array('wk'.$y.'hand_avg' => ($team_agg['wk'.($y-1).'agg']+$team_agg['wk'.($y-2).'agg']+$team_agg['wk'.($y-3).'agg'])/3);
                }
            }else{
                $team_agg_agg += $team_agg['wk'.$y.'agg'];
                $team_agg_avg += array('wk'.$y.'agg_avg' => 0);
                $team_hand_avg += array('wk'.$y.'hand_avg' => 0);
            }
        }

        // Close out the team stats by adding them to the team in the divisions array
        $divisions[$div][$team] += array('wk_agg' => $team_agg);
        $divisions[$div][$team] += array('wk_agg_avg' => $team_agg_avg);
        $divisions[$div][$team] += array('wk_hand_avg' => $team_hand_avg);
        $t++;
    }
}

// Calculate handicaps and totals for each team
foreach($divisions as $div => $teams){
    $div_teams = array_keys($teams);

    foreach($teams as $team=>$numbers){
        $team_handicap = array();
        $team_total = array();

        // Loop through each week
        for($wk=1;$wk<16;$wk++){
            $opp_team = $div_teams[($numbers['opp_teams'][($wk-1)]-1)];

            if($wk <= $match_completed+1){
                // Calculate handicap based on opponent's handicap
                if($numbers['wk_hand_avg']['wk'.$wk.'hand_avg'] < $teams[$opp_team]['wk_hand_avg']['wk'.$wk.'hand_avg']){
                    $team_handicap += array('wk'.$wk.'handicap' => round(($teams[$opp_team]['wk_hand_avg']['wk'.$wk.'hand_avg'] - $numbers['wk_hand_avg']['wk'.$wk.'hand_avg']) * 0.8));
                } else {
                    $team_handicap += array('wk'.$wk.'handicap' => 0);
                }

                // Calculate total for the week
                $team_total += array('wk'.$wk.'total' => ($team_handicap['wk'.$wk.'handicap'] + $numbers['wk_agg']['wk'.$wk.'agg']));
            } else {
                // Weeks beyond the completed match, set handicap and total to 0
                $team_handicap += array('wk'.$wk.'handicap' => 0);
                $team_total += array('wk'.$wk.'total' => 0);
            }
        }

        // Add handicap and total information to the divisions array
        $divisions[$div][$team] += array('wk_handicap' => $team_handicap);
        $divisions[$div][$team] += array('wk_total' => $team_total);
    }
}

// Calculate wins for each team
$tie_breakers = array();
$result = $conn->query("CALL current_tie_breaker()");
while($row = $result->fetch(PDO::FETCH_ASSOC)){
    // Collect tie-breaker information
    if(array_key_exists($row['teams'],$tie_breakers)){
        $tie_breakers[$row['teams']] += $row['week'];
    } else {
        $tie_breakers += array($row['teams']=>$row['week']);
    }
}
// Free the result set from the stored procedure
$result->closeCursor();

foreach($divisions as $div => $teams){
    $div_teams = array_keys($teams);

    foreach($teams as $team => $numbers){
        $wins = array();
        $wins_total = 0;

        // Loop through each week
        for($wk=1;$wk<16;$wk++){
            $opp_team = $div_teams[($numbers['opp_teams'][($wk-1)]-1)];

            if($wk <= $match_completed) {
                // Compare total scores to determine wins
                if($numbers['wk_total']['wk'.$wk.'total'] > $teams[$opp_team]['wk_total']['wk'.$wk.'total']){
                    $wins += array('wk'.$wk.'win' => 1);
                } else {
                    // Use tie-breaker information to determine wins in case of a tie
                    if(array_key_exists($team,$tie_breakers)){
                        if(is_string($tie_breakers[$team])){
                            if($tie_breakers[$team] == $wk){
                                $wins += array('wk'.$wk.'win' => 1);
                            } else {
                                $wins += array('wk'.$wk.'win' => 0);
                            }
                        } else {
                            foreach($tie_breakers[$team] as $wek){
                                if($wek == $wk){
                                    $wins += array('wk'.$wk.'win' => 1);
                                } else {
                                    $wins += array('wk'.$wk.'win' => 0);
                                }
                            }
                        }
                    } else {
                        $wins += array('wk'.$wk.'win' => 0);
                    }
                }
            } else {
                // Weeks beyond the completed match, set wins to 0
                $wins += array('wk'.$wk.'win' => 0);
            }
        }
        // Add win information to the divisions array
        $divisions[$div][$team] += array('wk_win' => $wins);
        $divisions[$div][$team] += array('team_wins' => array_sum($wins));
    }
}

// Initialize arrays to track individual winners, runners-up, and close competitors for each class
$individual_winners = array('A'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'B'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'C'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'D'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'E'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'F'=>array('high'=>0,'avg'=>0,'most_improv'=>0)
                        );
$individual_winners_name = array('A'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'B'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'C'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'D'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'E'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'F'=>array('high'=>0,'avg'=>0,'most_improv'=>0)
                        );
$individual_runner = array('A'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'B'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'C'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'D'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'E'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'F'=>array('high'=>0,'avg'=>0,'most_improv'=>0)
                        );                      
$individual_runner_name = array('A'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'B'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'C'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'D'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'E'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'F'=>array('high'=>0,'avg'=>0,'most_improv'=>0)
                        );
$individual_close = array('A'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'B'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'C'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'D'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'E'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'F'=>array('high'=>0,'avg'=>0,'most_improv'=>0)
                        );
$individual_close_name = array('A'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'B'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'C'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'D'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'E'=>array('high'=>0,'avg'=>0,'most_improv'=>0),
                            'F'=>array('high'=>0,'avg'=>0,'most_improv'=>0)
                        );

// Iterate through divisions, teams, and shooters to determine individual winners and statistics
foreach($divisions as $teams){
    foreach($teams as $numbers){ 
        $t=0;

        foreach($numbers as $number => $names){
            if (is_numeric($number)){
                if($t<6){
                    $name=array_keys($names)[0];
                    $class = $names[$name]['class'];
                    
                    // Check if shooter name exists in the $lyas_arr
                    if(array_key_exists($name, $lyas_arr)){
                        // Update individual winners, runners-up, and close competitors based on high score
                        if($individual_winners[$class]['high'] < $names[$name]['high']){
                            // Update values for high score
                            $individual_close[$class]['high'] = $individual_runner[$class]['high'];
                            $individual_close_name[$class]['high'] = $individual_runner_name[$class]['high'];
                            $individual_runner[$class]['high'] = $individual_winners[$class]['high'];
                            $individual_runner_name[$class]['high'] = $individual_winners_name[$class]['high'];
                            $individual_winners[$class]['high'] = $names[$name]['high'];
                            $individual_winners_name[$class]['high'] = $name;
                        }elseif($individual_runner[$class]['high'] < $names[$name]['high']){
                            // Update values for the second-highest score
                            $individual_close[$class]['high'] = $individual_runner[$class]['high'];
                            $individual_close_name[$class]['high'] = $individual_runner_name[$class]['high'];
                            $individual_runner[$class]['high'] = $names[$name]['high'];
                            $individual_runner_name[$class]['high'] = $name;
                        }elseif($individual_close[$class]['high'] < $names[$name]['high']){
                            // Update values for the third-highest score
                            $individual_close[$class]['high'] = $names[$name]['high'];
                            $individual_close_name[$class]['high'] = $name;
                        }

                        // Update individual winners, runners-up, and close competitors based on average score
                        if($individual_winners[$class]['avg'] < $names[$name]['avg']){
                            // Update values for highest average score
                            $individual_close[$class]['avg'] = $individual_runner[$class]['avg'];
                            $individual_close_name[$class]['avg'] = $individual_runner_name[$class]['avg'];
                            $individual_runner[$class]['avg'] = $individual_winners[$class]['avg'];
                            $individual_runner_name[$class]['avg'] = $individual_winners_name[$class]['avg'];
                            $individual_winners[$class]['avg'] = $names[$name]['avg'];
                            $individual_winners_name[$class]['avg'] = $name;
                        }elseif($individual_runner[$class]['avg'] < $names[$name]['avg']){
                            // Update values for second-highest average score
                            $individual_close[$class]['avg'] = $individual_runner[$class]['avg'];
                            $individual_close_name[$class]['avg'] = $individual_runner_name[$class]['avg'];
                            $individual_runner[$class]['avg'] = $names[$name]['avg'];
                            $individual_runner_name[$class]['avg'] = $name;
                        }elseif($individual_close[$class]['avg'] < $names[$name]['avg']){
                            // Update values for third-highest average score
                            $individual_close[$class]['avg'] = $names[$name]['avg'];
                            $individual_close_name[$class]['avg'] = $name;
                        }
                        
                        // Update individual winners, runners-up, and close competitors based on the most improvement
                        if($individual_winners[$class]['most_improv'] < ($names[$name]['avg']-$names[$name]['lya'])){
                            // Update values for most improvement
                            $individual_close[$class]['most_improv'] = $individual_runner[$class]['most_improv'];
                            $individual_close_name[$class]['most_improv'] = $individual_runner_name[$class]['most_improv'];
                            $individual_runner[$class]['most_improv'] = $individual_winners[$class]['most_improv'];
                            $individual_runner_name[$class]['most_improv'] = $individual_winners_name[$class]['most_improv'];
                            $individual_winners[$class]['most_improv'] = ($names[$name]['avg']-$names[$name]['lya']);
                            $individual_winners_name[$class]['most_improv'] = $name;
                        }elseif($individual_runner[$class]['most_improv'] < ($names[$name]['avg']-$names[$name]['lya'])){
                            // Update values for second-most improvement
                            $individual_close[$class]['most_improv'] = $individual_runner[$class]['most_improv'];
                            $individual_close_name[$class]['most_improv'] = $individual_runner_name[$class]['most_improv'];
                            $individual_runner[$class]['most_improv'] = ($names[$name]['avg']-$names[$name]['lya']);
                            $individual_runner_name[$class]['most_improv'] = $name;
                        }elseif($individual_close[$class]['most_improv'] < ($names[$name]['avg']-$names[$name]['lya'])){
                            // Update values for third-most improvement
                            $individual_close[$class]['most_improv'] = ($names[$name]['avg']-$names[$name]['lya']);
                            $individual_close_name[$class]['most_improv'] = $name;
                        }
                    }
                $t++;
                }
            }
        }
    }
}

// Initialize arrays to track team winners and their respective shooters
$team_winners = array();
$team_winners_names = array();

// Iterate through divisions to determine team winners and shooters
foreach($divisions as $div=>$teams){
    if($div != 'U'){
        // Initialize variables to track team wins and shooters
        $team_winners += array($div=> '');
        $team_winners_names += array($div => array());
        $wins = 0;
        $team_names = array_keys($teams);
        $opp_teams = array();
        $tm = 1;

        // Create an array to store the corresponding team names
        foreach($team_names as $name){
            $opp_teams += array($tm => $name);
            $tm ++;
        }

        // Iterate through team names to determine team winners
        foreach($team_names as $name){
            if($teams[$name]['team_wins']>$wins){
                // Update team winner if they have more wins
                $wins = $teams[$name]['team_wins'];
                $team_winners[$div] = $name;
            }elseif($teams[$name]['team-wins']=$wins){
                // Check for tiebreakers if teams have the same number of wins
                $win = 0;
                $totals = 0;

                // Iterate through weeks to check head-to-head performance
                for($x=0;$x<count($teams[$name]['opp_teams']);$x++){
                    if($opp_teams[$teams[$name]['opp_teams'][$x]] == $team_winners[$div]){
                        $win += $teams[$name]['wk_win']['wk'.($x+1).'win'];
                        $totals++;
                    }
                }
                
                // Check for majority wins in head-to-head matches
                if($win/$totals > 0.5){
                    $wins = $teams[$name]['team_wins'];
                    $team_winners[$div]=$name;
                }elseif($win/$totals == 0.5){
                    // Check for the highest aggregate average score as a tiebreaker
                    if(round($teams[$name]['wk_agg_avg']['wk'.$match_completed.'agg_avg'],-4) > round($teams[$team_winners[$div]]['wk_agg_avg']['wk'.$match_completed.'agg_avg'],-4)){
                        $wins = $teams[$name]['team_wins'];
                        $team_winners[$div]=$name;
                    }
                }
            }
        }
    }

    // Iterate through teams to determine shooters for the winning team
    foreach($teams as $team=>$numbers){
        if($team == $team_winners[$div]){
            $s=0;
            
            // Iterate through shooters to collect their names
            foreach($numbers as $number => $shooters){
                if(is_numeric($number)){
                    if($s<6){
                        foreach($shooters as $name => $scores){
                            array_push($team_winners_names[$div],$name);
                            break;
                        }
                        $s++;
                    }
                }
            }
        }
    }
}

// Uncomment the following lines to debug or display results
// echo json_encode($team_winners_names);
// echo 'winners=' . json_encode($individual_winners) . ', runner_up=' . json_encode($individual_runner) . ', close=' . json_encode($individual_close);
// echo json_encode($lyas_arr);
// echo json_encode($divisions);
?>