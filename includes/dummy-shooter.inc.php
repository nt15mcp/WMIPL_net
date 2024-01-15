<?php

// start a new session if not already running
if(!isset($_SESSION)) {
    session_start();
}  
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
        $name = substr($data["name"],0,strpos($data["name"],"_"));
        $week = substr($data["name"],strpos($data["name"],"_")+1);

        // Initialize id variables
        $shooter_id = 0;
        $match_id = 0;

        $sql = "SELECT id FROM shooters WHERE display_name = :name";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        if($shooter_id = $stmt->fetchColumn()){
            $sql = "SELECT id FROM matches WHERE match_num=:week AND match_date >= (SELECT start_date FROM seasons WHERE id = (SELECT MAX(id) FROM seasons))";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':week', $week, PDO::PARAM_STR);
            $stmt->execute();

            if($match_id = $stmt->fetchColumn()){
                $sql = "INSERT INTO dummy_shooters (shooter_id, starting_match_id) VALUES (:shooter_id, :match_id)";
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':shooter_id', $shooter_id, PDO::PARAM_INT);
                $stmt->bindParam(':match_id', $match_id, PDO::PARAM_INT);
                if(!$stmt->execute()){
                    echo "error=could not insert into dummy_shooters shooter=" . $name . " for week=" . $week . ".";
                    exit();
                } else {
                    echo "Inserted shooter: ".$name." into dummy_shooters for week: ".$week.".";
                }
            } else {
                echo "error=no week found";
                exit();
            }
        }else {
            echo "error=no such shooter";
            exit();
        }
    }
}