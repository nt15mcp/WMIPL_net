<?php
// pull in the database helper
require 'dbh.inc.php';

// start with a fresh array
$divisions = array();
// get data from the database for all of the current season of shooters and scores
$result = $conn->query("CALL current_roster()");
//while loop runs for all the data
while($row = $result->fetch_assoc() ){
    // if this is the first row, start the array
    if(!$divisions){
        // multidimensional array where shooter and shooter number are within team which is within division
        $divisions = array($row['division']=>array($row['team']=>array($row['number']=>$row['name'])));
    } else {
        // if this is a new division, create a new division in the array
        if(!array_key_exists($row['division'],$divisions)){
            $divisions += array($row['division']=>array($row['team']=>array($row['number']=>$row['name'])));
        } else {
            // if this is a new team, create a new team in the division
            if(!array_key_exists($row['team'], $divisions[$row['division']])){
                $divisions[$row['division']] += array($row['team']=>array($row['number']=>$row['name']));
            // this is another shooter in the current division and current team
            } else {
                $divisions[$row['division']][$row['team']] += array($row['number']=>$row['name']);
            }
        }
    }
}
// free the result set from the stored procedure calll
$conn -> next_result();
// $divisions is now an array of [division:[team:[shooter_num, shooter_name],[shooter_num, shooter_name]],[team:[shooter_num, shooter_name],[shooter_num, shooter_name]]],division:[team:[shooter_num, shooter_name],[shooter_num, shooter_name]],[team:[shooter_num, shooter_name],[shooter_num, shooter_name]]]]
//echo json_encode($divisions); //check your work!

//start with a fresh array
$scores = array();
$division = '';
$team = '';
$shooter = '';
$number = 0;
$qual = array();
// get the scores for the season and add them to the arrays
$result = $conn->query("CALL current_season()");
// while loop runs for all the data
while($row = $result->fetch_assoc()){
    // if this is the first row, start the array
    if(!$scores){
        //multidimensional array where the shooter scores are compiled by week
        if(substr($row['wk'],0,1) !='Q'){
            $shooter = $row['name'];
            $division = $row['division'];
            $team = $row['team'];
            $number = $row['number'];
            $scores = array($row['wk']=>array($row['score'],$row['changed']));
        // qual score -> add it up for lya
        } else {
            $shooter = $row['name'];
            $division = $row['division'];
            $team = $row['team'];
            $number = $row['number'];
            $qual += $row['score'];
        }
    // see if this is a new shooter
    } elseif ($shooter != $row['name']){
        // close up the shooter
        // verify this is not a new shooter, if so calculate lya
        if ($qual){
            $scores += array('lya'=>(array_sum($qual)/count($qual)));
            // clear the qual
            $qual = array();
        }
        // put the shooter's scores into the $divisions array
        //echo $division.', '.$team.', '.$number.', '.$shooter;
        $divisions[$division][$team][$number] = array($shooter => $scores);
        //start with a new array
        $scores = array();
        // add the shooter to the array
        if(substr($row['wk'],0,1) !='Q'){
            $shooter = $row['name'];
            $division = $row['division'];
            $team = $row['team'];
            $number = $row['number'];
            $scores = array($row['wk']=>array($row['score'],$row['changed']));
        // qual score -> add it up for lya
        } else {
            $shooter = $row['name'];
            $division = $row['division'];
            $team = $row['team'];
            $number = $row['number'];
            $qual += $row['score'];
        }
    // not a new shooter and not an empty array
    } else {
        // add the shooter to the array
        if(substr($row['wk'],0,1) !='Q'){
           // echo 'not a new shooter';
            $scores += array($row['wk']=>array($row['score'],$row['changed']));
        // qual score -> add it up for lya
        } else {
            array_push($qual,$row['score']);
        }
    }
}
// put the last shooter's scores into the $divisions array
if ($qual){
    $scores += array('lya'=>(array_sum($qual)/count($qual)));
}
$divisions[$division][$team][$number] = array($shooter => $scores);
 // free the result set from the stored procedure
$conn -> next_result();

// divisions should now have scores attached to each shooter's name
//echo json_encode($divisions); // check your work!

// start with a fresh array
$lyas_arr = array();
// get lyas for returning shooters
$result = $conn->query("CALL current_lyas()");
while($row = $result->fetch_assoc()){
    $lyas_arr += array($row['name']=>$row['score']);
}
//echo json_encode($scores);
// free the result set from the stored procedure
$conn -> next_result();

// cycle through the existing divisions and add lyas to shooters
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

// create a new variable for scores calculations
$match_completed = 0;
// get the latest match number from db
$result = $conn->query("CALL match_completed");
$res_arr = $result->fetch_assoc();
$match_completed = $res_arr['match_num'];
$conn->next_result();

//create a new variable to hold the classes
$classes = array();
// get current class breakdown
$result = $conn->query("CALL current_class");
$classes = $result->fetch_assoc();
$conn->next_result();

//echo json_encode($classes);
//echo json_encode($match_completed);
// $divisions should now include all current season divisions, teams, shooters and scores including last year averages
// echo json_encode($divisions); // Check your work!

// Calculate all of the missing scores
$agg = 0;
foreach($divisions as $div => $teams){
    foreach($teams as $team => $numbers){
        $lyas = 0;
        foreach($numbers as $number => $shooters){
            $s=0;
            foreach($shooters as $shooter => $scores){
                $agg = 0;
                $high = 0;
                $wks = 0;
                for($wk=1;$wk< 16;$wk++){
                    if(!array_key_exists($wk,$scores)){
                        if($wk < $match_completed){
                            //echo json_encode($scores).'<br>';
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
        $divisions[$div][$team] += array('lyaas'=>$lyas);
    }
}

// add in dummy shooters where appropriate
foreach($divisions as $div => $teams){
    foreach($teams as $team=>$numbers){
        $lyas = $divisions[$div][$team]['lyaas'];
        //echo 'starting lyaas for '.$team.'='.$lyas.'<br>';
        $numb_keys = array_keys($numbers);
        for($x=0;$x<6;$x++){
            // build the test shooter number to see if shooter exists
            $test_num = $numb_keys[0] - ($numb_keys[0]%10) + $x;
            //echo $test_num.'<br>';
            // check to see if shooter exists
            if(!array_key_exists($test_num,$numbers)){
                // shooter does not exist, get the teams average of lya
                $team_lya = number_format($lyas/(count($divisions[$div][$team])-1),0);
                // create an empty array to hold scores
                $dum_scores = array();
                // create scores for each week
                for($wk=1;$wk<16;$wk++){
                    // only add scores for weeks that are completed
                    if($wk > $match_completed){
                        $dum_scores += array($wk=>array('0','0','0'));
                    } else {
                        $dum_scores += array($wk=>array($team_lya, '0','0'));
                    }
                }
                // determine the class of the fake shooter
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
                // add to the score array the necessary statistics
                $dum_scores += array('class'=>$class);
                $dum_scores += array('agg'=>$team_lya*$match_completed);
                $dum_scores += array('avg'=>$team_lya);
                $dum_scores += array('lya'=>$team_lya);
                $dum_scores += array('high'=>$team_lya);
                // push the fake shooter, scores, and statistics to the divisions array
                $divisions[$div][$team] += array($test_num=>array('DUMMY'=>$dum_scores));
                // add the fake shooter's lya to the lyaa for the team
                $lyas += $team_lya;
                //echo 'dummy added to '.$team.'<br>';
            }
        }          
        //echo 'ending lyaas for '.$team.'= '.$lyas.'<br>';
        // replace the team's lyaa with the new one including the fake shooters
        $divisions[$div][$team]['lyaas'] = $lyas;
        // sort it for readability
        ksort($divisions[$div][$team]);
    }
}

//create an array to represent opposing teams
$opp_teams_array = array([2,3,4,2,3,4,2,3,4,2,3,4,2,3,4],[1,4,3,1,4,3,1,4,3,1,4,3,1,4,3],[4,1,2,4,1,2,4,1,2,4,1,2,4,1,2],[3,2,1,3,2,1,3,2,1,3,2,1,3,2,1]);
if($match_completed < 15){
    $hand_matches = $match_completed + 2;
} else {
    $hand_matches = $match_completed + 1;
}
// create the team statistics and add the opposing teams array to the team
foreach($divisions as $div=>$teams){
    $t = 0;
    foreach($teams as $team => $numbers){
        // add opposing teams
        $divisions[$div][$team] += array('opp_teams'=>$opp_teams_array[$t]);
        // reset variables for each team
        $team_agg = array();
        $team_agg_agg = 0;
        $team_agg_avg = array();
        $team_hand_avg = array();
        $n = 0;
        foreach($numbers as $number=>$shooters){
            //echo json_encode($shooters).'<br>';
            if($n<6){
                $w = 1;
                foreach($shooters as $name => $scores){
                    for($w=1;$w<16;$w++){
                        //echo json_encode($score).'<br>';
                        // add each member's weekly score to the team agg for the week
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
        for($y=1;$y<16;$y++){
            //echo json_encode($team_agg).'<br>';
            // average the team's weekly aggs over each week of the season and calculate the rolling 3 week handicap average       
            //echo $divisions[$div][$team]['lyaas'].'<br>';                    
            if($y<$match_completed+1){
                if($y==1){
                    $team_agg_agg += $team_agg['wk'.$y.'agg'];
                    //echo 'team_agg_agg='.$team_agg_agg.', $y='.$y.'<br>';
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
        // close out the team stats by adding them to the team in the divisions array
        $divisions[$div][$team] += array('wk_agg' => $team_agg);
        $divisions[$div][$team] += array('wk_agg_avg' => $team_agg_avg);
        $divisions[$div][$team] += array('wk_hand_avg' => $team_hand_avg);
        $t++;
    }
}

// calculate handicaps and totals for each team
foreach($divisions as $div => $teams){
    $div_teams = array_keys($teams);
    foreach($teams as $team=>$numbers){
        $team_handicap = array();
        $team_total = array();
        for($wk=1;$wk<16;$wk++){
            $opp_team = $div_teams[($numbers['opp_teams'][($wk-1)]-1)];
            if($wk <= $match_completed+1){
                if($numbers['wk_hand_avg']['wk'.$wk.'hand_avg'] < $teams[$opp_team]['wk_hand_avg']['wk'.$wk.'hand_avg']){
                    $team_handicap += array('wk'.$wk.'handicap' => round(($teams[$opp_team]['wk_hand_avg']['wk'.$wk.'hand_avg'] - $numbers['wk_hand_avg']['wk'.$wk.'hand_avg']) * 0.8));
                } else {
                    $team_handicap += array('wk'.$wk.'handicap' => 0);
                }
                $team_total += array('wk'.$wk.'total' => ($team_handicap['wk'.$wk.'handicap'] + $numbers['wk_agg']['wk'.$wk.'agg']));
            } else {
                $team_handicap += array('wk'.$wk.'handicap' => 0);
                $team_total += array('wk'.$wk.'total' => 0);
            }
        }
        $divisions[$div][$team] += array('wk_handicap' => $team_handicap);
        $divisions[$div][$team] += array('wk_total' => $team_total);
    }
}

// calculate wins for each team
foreach($divisions as $div => $teams){
    $div_teams = array_keys($teams);
    foreach($teams as $team => $numbers){
        $wins = array();
        $wins_total = 0;
        for($wk=1;$wk<16;$wk++){
            $opp_team = $div_teams[($numbers['opp_teams'][($wk-1)]-1)];
            if($wk <= $match_completed) {
                if($numbers['wk_total']['wk'.$wk.'total'] > $teams[$opp_team]['wk_total']['wk'.$wk.'total']){
                    $wins += array('wk'.$wk.'win' => 1);
                } else {
                    $wins += array('wk'.$wk.'win' => 0);
                }
            } else {
                $wins += array('wk'.$wk.'win' => 0);
            }
        }
        $divisions[$div][$team] += array('wk_win' => $wins);
        $divisions[$div][$team] += array('team_wins' => array_sum($wins));
    }
}

// calculate individual winners
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
foreach($divisions as $teams){
    foreach($teams as $numbers){ 
        $t=0;
        foreach($numbers as $names){
            if($t<6){
                $name=array_keys($names)[0];
                $class = $names[$name]['class'];
                if(array_key_exists($name, $lyas_arr)){
                    //echo $names[$name]['avg']-$names[$name]['lya'].'<br>';
                    if($individual_winners[$class]['high'] < $names[$name]['high']){
                        $individual_close[$class]['high'] = $individual_runner[$class]['high'];
                        $individual_close_name[$class]['high'] = $individual_runner_name[$class]['high'];
                        $individual_runner[$class]['high'] = $individual_winners[$class]['high'];
                        $individual_runner_name[$class]['high'] = $individual_winners_name[$class]['high'];
                        $individual_winners[$class]['high'] = $names[$name]['high'];
                        $individual_winners_name[$class]['high'] = $name;
                    }elseif($individual_runner[$class]['high'] < $names[$name]['high']){
                        $individual_close[$class]['high'] = $individual_runner[$class]['high'];
                        $individual_close_name[$class]['high'] = $individual_runner_name[$class]['high'];
                        $individual_runner[$class]['high'] = $names[$name]['high'];
                        $individual_runner_name[$class]['high'] = $name;
                    }elseif($individual_close[$class]['high'] < $names[$name]['high']){
                        $individual_close[$class]['high'] = $names[$name]['high'];
                        $individual_close_name[$class]['high'] = $name;
                    }
                    if($individual_winners[$class]['avg'] < $names[$name]['avg']){
                        $individual_close[$class]['avg'] = $individual_runner[$class]['avg'];
                        $individual_close_name[$class]['avg'] = $individual_runner_name[$class]['avg'];
                        $individual_runner[$class]['avg'] = $individual_winners[$class]['avg'];
                        $individual_runner_name[$class]['avg'] = $individual_winners_name[$class]['avg'];
                        $individual_winners[$class]['avg'] = $names[$name]['avg'];
                        $individual_winners_name[$class]['avg'] = $name;
                    }elseif($individual_runner[$class]['avg'] < $names[$name]['avg']){
                        $individual_close[$class]['avg'] = $individual_runner[$class]['avg'];
                        $individual_close_name[$class]['avg'] = $individual_runner_name[$class]['avg'];
                        $individual_runner[$class]['avg'] = $names[$name]['avg'];
                        $individual_runner_name[$class]['avg'] = $name;
                    }elseif($individual_close[$class]['avg'] < $names[$name]['avg']){
                        $individual_close[$class]['avg'] = $names[$name]['avg'];
                        $individual_close_name[$class]['avg'] = $name;
                    }
                    if($individual_winners[$class]['most_improv'] < ($names[$name]['avg']-$names[$name]['lya'])){
                        $individual_close[$class]['most_improv'] = $individual_runner[$class]['most_improv'];
                        $individual_close_name[$class]['most_improv'] = $individual_runner_name[$class]['most_improv'];
                        $individual_runner[$class]['most_improv'] = $individual_winners[$class]['most_improv'];
                        $individual_runner_name[$class]['most_improv'] = $individual_winners_name[$class]['most_improv'];
                        $individual_winners[$class]['most_improv'] = ($names[$name]['avg']-$names[$name]['lya']);
                        $individual_winners_name[$class]['most_improv'] = $name;
                    }elseif($individual_runner[$class]['most_improv'] < ($names[$name]['avg']-$names[$name]['lya'])){
                        $individual_close[$class]['most_improv'] = $individual_runner[$class]['most_improv'];
                        $individual_close_name[$class]['most_improv'] = $individual_runner_name[$class]['most_improv'];
                        $individual_runner[$class]['most_improv'] = ($names[$name]['avg']-$names[$name]['lya']);
                        $individual_runner_name[$class]['most_improv'] = $name;
                    }elseif($individual_close[$class]['most_improv'] < ($names[$name]['avg']-$names[$name]['lya'])){
                        $individual_close[$class]['most_improv'] = ($names[$name]['avg']-$names[$name]['lya']);
                        $individual_close_name[$class]['most_improv'] = $name;
                    }
                }
            $t++;
            }
        }
    }
}
//echo 'winners='.json_encode($individual_winners).', runner_up='.json_encode($individual_runner).', close='.json_encode($individual_close);
//echo json_encode($lyas_arr);
//echo json_encode($divisions);

?>