<?php
/**
 * Scores Retrieval
 *
 * This script fetches shooter and score data from the database and organizes it into arrays.
 * It calls stored procedures ('current_roster' and 'current_season') to retrieve the data.
 * The shooter data is organized by division, team, and shooter, while the score data is organized
 * by shooter, week, and score.
 * The script uses a common database login file (dbh.inc.php) for database connection.
 *
 */

// Include the database helper
require 'dbh.inc.php';

// Initialize the divisions array
$divisions = array();

// Get data from the database for all the current season of shooters and scores
$result = $conn->query("CALL current_roster()");

// While loop runs for all the data
while($row = $result->fetch(PDO::FETCH_ASSOC)){
    // If this is the first row, start the array
    if(!$divisions){
        // Multidimensional array where shooter and shooter number are within team, which is within division
        $divisions = array($row['division']=>array($row['team']=>array($row['number']=>$row['name'])));
    } else {
        // If this is a new team, create a new team in the division
        if(!array_key_exists($row['division'],$divisions)){
            $divisions += array($row['division']=>array($row['team']=>array($row['number']=>$row['name'])));
        } else {
            // if this is a new team, create a new team in the division
            if(!array_key_exists($row['team'], $divisions[$row['division']])){
                $divisions[$row['division']] += array($row['team']=>array($row['number']=>$row['name']));
            // This is another shooter in the current division and current team
            } else {
                $divisions[$row['division']][$row['team']] += array($row['number']=>$row['name']);
            }
        }
    }
}

// Free the result set from the stored procedure call
$conn->closeCursor();

// Start with a fresh array
$scores = array();
$division = '';
$team = '';
$shooter = '';
$number = 0;
$qual = array();

// Get the scores for the season and add them to the arrays
$result = $conn->query("CALL current_season()");

// While loop runs for all the data
while($row = $result->fetch(PDO::FETCH_ASSOC)){
    // If this is the first row, start the array
    if(!$scores){
        // Multidimensional array where the shooter scores are compiled by week
        $shooter = $row['name'];
        $division = $row['division'];
        $team = $row['team'];
        $number = $row['number'];
        $scores = array($row['wk']=>array($row['score'],$row['changed']));
    // See if this is a new shooter
    } elseif ($shooter != $row['name']){
        // Close up the shooter
        // Put the shooter's scores into the $divisions array
        $divisions[$division][$team][$number] = array($shooter => $scores);
        
        // Start with a new array
        $scores = array();
        
        // Add the shooter to the array
        $shooter = $row['name'];
        $division = $row['division'];
        $team = $row['team'];
        $number = $row['number'];
        $scores = array($row['wk']=>array($row['score'],$row['changed']));
    // Not a new shooter and not an empty array
    } else {
        // Add the shooter to the array
        $scores += array($row['wk']=>array($row['score'],$row['changed']));
    }
}

// Put the last shooter's scores into the $divisions array
$divisions[$division][$team][$number] = array($shooter => $scores);
 
// Free the result set from the stored procedure
$conn->closeCursor();
?>