<?php
/**
 * WMIPL Statistics Calculator
 *
 * This script compiles each shooter of the WMIPL season and calculates their statistics
 */
// Include the database helper
require 'dbh.inc.php';

//Initialize a fresh array for the season
$shooters = array();

/**
 * SECTION:  The following code starts the shooters array and adds in the name
 * along with their position in the league (the starting position at least)
 */
// Retrieve the shooters for the season and add them to the arrays
$result = $conn->query("CALL current_roster()");

// Iterate through the results
while($row = $result->fetch_assoc() ){
    // Check if shooters array is empty
    if(!$shooters){
        // Create scores and team positions for the first shooter
        // Add scores for qualifying weeks
        for($wk=1;$wk<4;$wk++){
            if($wk == 1){
                // First entry for new shooter, add to array
                $shooters = array(
                    $row['name']=>
                        array(
                            'Q'.$wk=>
                                array(
                                    'scores'=>
                                        array(
                                            'value'=>0,
                                            'changed'=>0,
                                            'missed'=>0
                                        ),
                                    'id'=>
                                        array(
                                            'div'=>
                                               array( 
                                                    $row['division'],
                                                    substr($row['number'],0,1)
                                               ),
                                            'team'=>
                                                array(
                                                    $row['team'],
                                                    substr($row['number'],1,1)
                                                ),
                                            'position'=>
                                                substr($row['number'],-1)
                                        )
                                    )
                        )
                );
            } else {
                // Add the rest to the same shooter
                $shooters[$row['name']] += array(
                    'Q'.$wk=>
                        array(
                            'scores'=>
                                array(
                                    'value'=>0,
                                    'changed'=>0,
                                    'missed'=>0
                                ),
                            'id'=>
                                array(
                                    'div'=>
                                        array(
                                            $row['division'],
                                            substr($row['number'],0,1)
                                        ),
                                    'team'=>
                                        array(
                                            $row['team'],
                                            substr($row['number'],1,1)
                                        ),
                                    'position'=>
                                        substr($row['number'],-1)
                                )
                        )
                );
            }
        }
        // Add scores for regular season
        for($wk=1;$wk<16;$wk++){
            $shooters[$row['name']] += array(
                $wk=>
                    array(
                        'scores'=>
                            array(
                                'value'=>0,
                                'changed'=>0,
                                'missed'=>1
                            ),
                        'id'=>
                            array(
                                'div'=>
                                    array(
                                        $row['division'],
                                        substr($row['number'],0,1)
                                    ),
                                'team'=>
                                    array(
                                        $row['team'],
                                        substr($row['number'],1,1)
                                    ),
                                'position'=>
                                    substr($row['number'],-1)
                            )
                    )
            );
        }
    } else {
        // Create scores and team positions for the rest of the shooters
        // Add scores for qualifying weeks
        for($wk=1;$wk<4;$wk++){
            if($wk == 1){
                // First entry for new shooter, add to array
                $shooters += array(
                    $row['name']=>
                        array(
                            'Q'.$wk=>
                                array(
                                    'scores'=>
                                        array(
                                            'value'=>0,
                                            'changed'=>0,
                                            'missed'=>0
                                        ),
                                    'id'=>
                                        array(
                                            'div'=>
                                               array( 
                                                    $row['division'],
                                                    substr($row['number'],0,1)
                                               ),
                                            'team'=>
                                                array(
                                                    $row['team'],
                                                    substr($row['number'],1,1)
                                                ),
                                            'position'=>
                                                substr($row['number'],-1)
                                        )
                                    )
                        )
                );
            } else {
                // Add the rest to the same shooter
                $shooters[$row['name']] += array(
                    'Q'.$wk=>
                        array(
                            'scores'=>
                                array(
                                    'value'=>0,
                                    'changed'=>0,
                                    'missed'=>0
                                ),
                            'id'=>
                                array(
                                    'div'=>
                                        array(
                                            $row['division'],
                                            substr($row['number'],0,1)
                                        ),
                                    'team'=>
                                        array(
                                            $row['team'],
                                            substr($row['number'],1,1)
                                        ),
                                    'position'=>
                                        substr($row['number'],-1)
                                )
                        )
                );
            }
        }
        // Add scores for regular season
        for($wk=1;$wk<16;$wk++){
            $shooters[$row['name']] += array(
                $wk=>
                    array(
                        'scores'=>
                            array(
                                'value'=>0,
                                'changed'=>0,
                                'missed'=>1
                            ),
                        'id'=>
                            array(
                                'div'=>
                                    array(
                                        $row['division'],
                                        substr($row['number'],0,1)
                                    ),
                                'team'=>
                                    array(
                                        $row['team'],
                                        substr($row['number'],1,1)
                                    ),
                                'position'=>
                                    substr($row['number'],-1)
                            )
                    )
            );
        }
    }
}

// Free the result set from the stored procedure
$conn -> next_result();

// Retrieve the lyas for each shooter
$result = $conn->query("CALL current_lyas()");

// Iterate through the results
while($row = $result->fetch_assoc()){
    if(array_key_exists($row['name'],$shooters)){
        // Shooter exists, add lya
        $shooters[$row['name']] += array('stats' =>array('lya' => $row['score']));
    } else {
        // Shooter does not exist, add shooter and lya
        $shooters += array($row['name']=>array('stats' =>array('lya' => $row['score'])));
    }
}

// Free the result set from the stored procedure
$conn -> next_result();

// Retrieve the scores for each shooter
$result = $conn->query("CALL current_season()");

// Iterate through the results
while($row = $result->fetch_assoc()){
    if(array_key_exists($row['name'], $shooters)){
        // Shooter exists, add score and changed status
        $shooters[$row['name']][$row['wk']]['scores']['value'] = intval($row['score']);
        $shooters[$row['name']][$row['wk']]['scores']['changed'] = intval($row['changed']);
        $shooters[$row['name']][$row['wk']]['scores']['missed'] = 0;
    } 
}

// Free the result set from the strored procedure
$conn -> next_result();

// Calculate lya for new shooters
foreach($shooters as $name => $wks){
    $lya = 0;
    $qcount = 0;
    if(!array_key_exists('stats',$wks)){
        if($wks['Q1']['scores']['value'] > 0) {
            $lya += $wks['Q1']['scores']['value'];
            $qcount ++;
        }
        if($wks['Q2']['scores']['value'] > 0){
            $lya += $wks['Q2']['scores']['value'];
            $qcount ++;
        }
        if($wks['Q3']['scores']['value'] > 0){
            $lya += $wks['Q3']['scores']['value'];
            $qcount ++;
        }
        if($qcount != 0){
            $shooters[$name] += array('stats' => array('lya'=> ($lya / $qcount)));
        }
    }
}

// Check your work
// echo json_encode($shooters);

// Retrieve current week for missed calcs
$result = $conn->query("CALL match_completed()");
$res_arr = $result->fetch_assoc();
$match_completed = $res_arr['match_num'];
$conn->next_result();

// Retrieve class standards
$result = $conn->query("CALL current_class()");
$classes = $result->fetch_assoc();
$conn->next_result();

// Initialize array for dummies
$dummies = array();
// Retrieve dummied shooters
$result = $conn->query("CALL current_dummies()");
while ($row = $result->fetch_assoc()){
    $dummies += array($row['name']=>$row['week']);
}
$conn->next_result();

// Calculate individual stats per shooter and add missed scores
foreach($shooters as $name => $wks){
    $agg = 0;
    $avg = 0;
    $completed = 0;
    $high = 0;
    $class = '';
    for($wk=1;$wk<16;$wk++){
        if($wk<=$match_completed && $wks[$wk]['scores']['missed']){    
            if($dummies && array_key_exists($name,$dummies)){
                if($wk >= $dummies[$name]){
                    $avg = (($agg + $shooters[$name]['stats']['lya'])/($completed+1));
                    $shooters[$name][$wk]['scores']['value'] = intval($avg);
                    $agg += $avg;
                    $completed++;
                }
            } else {
                $missed = (($agg + $shooters[$name]['stats']['lya'])/($wk+1))-10;
                $shooters[$name][$wk]['scores']['value'] = $missed;
                $agg += $missed;
                $completed++;
                if($high < $missed){
                    $high = $missed;
                }
            }
        } elseif(!$wks[$wk]['scores']['missed']){
            $agg += $wks[$wk]['scores']['value'];
            $completed ++;
            if($high < $wks[$wk]['scores']['value']){
                $high = $wks[$wk]['scores']['value'];
            }
        } else {
            $shooters[$name][$wk]['scores']['missed'] = 0;
        }
    }
    foreach($classes as $key=>$value){
        if($shooters[$name]['stats']['lya'] > $value && $class == ''){
            $class = $key;
        }
    }
    $avg = ($agg + $shooters[$name]['stats']['lya'])/($completed + 1);
    $shooters[$name]['stats'] += array('agg'=> $agg, 'avg' => $avg, 'high' => $high, 'weeks' => $completed, 'class' => $class);
    if($dummies && array_key_exists($name,$dummies)){
        $shooters['DUMMY > WK '.$dummies[$name]] = $shooters[$name];
        unset($shooters[$name]);
    }
}

//echo json_encode($shooters);

?>