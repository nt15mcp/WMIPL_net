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
        $divisions = array($row['division']=>array($row['team']=>array($row['number'], $row['name'])));
    } else {
        // if this is a new division, create a new division in the array
        if(!array_key_exists($row['division'],$divisions)){
            $divisions += array($row['division']=>array($row['team']=>array($row['number'], $row['name'])));
        } else {
            // if this is a new team, create a new team in the division
            if(!array_key_exists($row['team'], $divisions[$row['division']])){
                $divisions[$row['division']] += array($row['team']=>array($row['number'], $row['name']));
            // this is another shooter in the current division and current team
            } else {
                array_push($divisions[$row['division']][$row['team']],array($row['number'], $row['name']));
            }
        }
    }
}
// free the result set from the stored procedure calll
$result -> free_result();
// $divisions is now an array of [division:[team:[shooter_num, shooter_name],[shooter_num, shooter_name]],[team:[shooter_num, shooter_name],[shooter_num, shooter_name]]],division:[team:[shooter_num, shooter_name],[shooter_num, shooter_name]],[team:[shooter_num, shooter_name],[shooter_num, shooter_name]]]]
echo json_encode($divisions); //check your work!
?>