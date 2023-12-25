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
$scores = array();
// get lyas for returning shooters
$result = $conn->query("CALL current_lyas()");
while($row = $result->fetch_assoc()){
    $scores += array($row['name']=>$row['score']);
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
                    if(array_key_exists($shooter, $scores)){
                        $divisions[$div][$team][$number][$shooter] += array('lya'=>$scores[$shooter]);
                    }
                }
            } else {
                $divisions[$div][$team][$number] = array($shooters => array('lya'=>$scores[$shooters]));
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
        foreach($numbers as $number => $shooters){
            foreach($shooters as $shooter => $scores){
                $high = 0;
                for($wk=1;$wk<=15;$wk++){
                    if(!array_key_exists($wk,$scores)){
                        if($wk < $match_completed){
                            //echo json_encode($scores).'<br>';
                            $missed_score = (($agg + $divisions[$div][$team][$number][$shooter]['lya'])/$wk)-10;
                            $divisions[$div][$team][$number][$shooter] += array($wk=>array($missed_score,'0','1'));
                            $agg += $missed_score;
                            if($high < $missed_score){
                                $high = $missed_score;
                            }
                        } else {
                            $divisions[$div][$team][$number][$shooter] += array($wk=>array('0','0','0'));
                        }
                    } else {
                        array_push($divisions[$div][$team][$number][$shooter][$wk],'0');
                        if($high < $scores[$wk][0]){
                            $high = $scores[$wk][0];
                        }
                        $agg += $scores[$wk][0];
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
                $avg = (($agg + $divisions[$div][$team][$number][$shooter]['lya'])/16);
                $divisions[$div][$team][$number][$shooter] += array('agg'=>$agg);
                $divisions[$div][$team][$number][$shooter] += array('avg'=>$avg);
                $divisions[$div][$team][$number][$shooter] += array('high'=>$high);
                $divisions[$div][$team][$number][$shooter] += array('class'=>$class);
                ksort($divisions[$div][$team][$number][$shooter]);
            }
        }
    }
}

//echo json_encode($divisions);

?>