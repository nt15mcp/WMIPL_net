<?php
/**
 * Tie Breaker Win Insertion Script
 *
 * This PHP script handles the insertion of data into the 'tie_breaker_win' table based on a POST request containing JSON data.
 *
 * Usage:
 * - This script expects a POST request with JSON data containing 'team' and 'week' information.
 * - It retrieves the corresponding 'team_id' and 'week_id' from the database.
 * - Inserts the data into the 'tie_breaker_win' table if both IDs are valid.
 *
 * Notes:
 * - Ensure that the 'dbh.inc.php' file is present and correctly configured for database connection.
 * - The script outputs success or error messages as appropriate.
 */
// start a new session if not already running
session_start();
// Verify the post comes from the right place
if(!isset($_SESSION['executive']) || $_SESSION['executive'] != 'Statistician'){
    // Shouldn't be here, send them home
    header("Location: ../index.php");
    exit();
 }
    // Check if a POST request has been made
    if(isset($_POST)){
        
        // Retrieve raw JSON data from the request
        $json = file_get_contents('php://input');
        // Decode JSON data into associative array
        $data = json_decode($json, true);

        // Check if JSON decoding was successful and data is not null
        if(!is_null($data)){
            // Include the database connection file
            require "dbh.inc.php";

            // Extract data from the decoded JSON
            $team = $data["team"];
            $week = $data["week"];
            
            // Initialize id variables
            $team_id = 0;
            $week_id = 0;

            // Query to retrieve team id based on team name
            $sql = "SELECT id FROM teams WHERE name=:team";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':team', $team, PDO::PARAM_STR);
            $stmt->execute();
            if($team_id = $stmt->fetchColumn()){
                // Query to retrieve week id based on match number and date
                $sql = "SELECT id FROM matches WHERE match_num=:match_num AND match_date >= (SELECT start_date FROM seasons WHERE id = (SELECT MAX(id) FROM seasons))";
                $stmt = $conn->prepare($sql);

                // Bind parameters and execute the statement
                $stmt->bindParam(':match_num', $week, PDO::PARAM_INT);
                $stmt->execute();
                if($week_id = $stmt->fetchColumn()){
                     // Insert data into tie_breaker_win table
                    $sql = "INSERT INTO tie_breaker_win (team_id, match_id) VALUES (:team_id,:week_id)";
                    $stmt = $conn->prepare($sql);

                    // Bind parameters and execute the statement
                    $stmt->bindParam(':team_id', $team_id, PDO::PARAM_INT);
                    $stmt->bindParam(':week_id', $week_id, PDO::PARAM_INT);
                    
                    // Check if the statement execution is successful
                    if(!$stmt->execute()){
                        // If insertion fails, exit with an error message
                        echo "error=could not insert into tie_breaker_win week=".$week_id." for team=".$team_id.".";
                        exit();
                    } else {
                        // If insertion is successful, echo a success message
                        echo "Inserted week: ".$week." and team: ".$team." into tie_breaker_win";
                    }
                } else {
                    // If no week is found, exit with an error message
                    echo "error=no week found";
                    exit();
                }
            } else {
                // If no team is found, exit with an error message
                echo "error=no such team";
                exit();
            }
        }
    }
?>