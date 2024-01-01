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

    // Check if a POST request has been made
    if(isset($_SERVER["CONTENT_TYPE"])){
        // Retrieve raw JSON data from the request
        $json = file_get_contents('php://input');
        // Decode JSON data into associative array
        $data = json_decode($json, true);

        // Check if JSON decoding was successful and data is not null
        if(!is_null($data)){
            // Include the database connection file
            require "dbh.inc.php";

            // Extract data from the decoded JSON
            $name = str_replace("'","",$data["name"]);
            $week = $data["week"];
            // Initialize id variables
            $shooter_id = 0;
            $match_id = 0;

            // See if this sets or unsets a dummy
            if($week != ''){
                echo "name=".$name.", week=".$week;
                // Set a dummy shooter
                // Query to retrieve shooter id based on shooter name
                $sql = "SELECT id FROM shooters WHERE display_name=?";
                $stmt = mysqli_stmt_init($conn);
                // Check if the SQL statement is prepared successfully
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    echo "error=".mysqli_error($conn);
                    exit();
                } else {
                    // Bind parameters and execute the statement
                    mysqli_stmt_bind_param($stmt, "s", $name);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    // Fetch the result into an associative array
                    if($row = mysqli_fetch_assoc($result)){
                        $shooter_id = $row['id'];
                    } else {
                        // If no shooter is found, exit with an error message
                        echo "error=no such shooter";
                        exit();
                    }
                }

                // Query to retrieve week id based on match number and date
                $sql = "SELECT id FROM matches WHERE match_num=? AND match_date >= (SELECT start_date FROM seasons WHERE id = (SELECT MAX(id) FROM seasons))";
                $stmt = mysqli_stmt_init($conn);

                // Check if the SQL statement is prepared successfully
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    echo "error=".mysqli_error($conn);
                    exit();
                } else {
                    // Bind parameters and execute the statement
                    mysqli_stmt_bind_param($stmt, "i", $week);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    // Fetch the result into an associative array
                    if($row = mysqli_fetch_assoc($result)){
                        $match_id = $row['id'];
                    } else {
                        // If no week is found, exit with an error message
                        echo "error=no week found";
                        exit();
                    }
                }

                // Check if both shooter_id and match_id are greater than 0
                if($shooter_id > 0 && $match_id > 0){
                    // Insert data into dummy_shooters table
                    $sql = "INSERT INTO dummy_shooters (shooter_id, starting_match_id) VALUES (?,?)";
                    $stmt = mysqli_stmt_init($conn);

                    // Check if the SQL statement is prepared successfully
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        echo "error=".mysqli_error($conn);
                        exit();
                    } else {
                        // Bind parameters and execute the statement
                        mysqli_stmt_bind_param($stmt, "ii", $shooter_id, $match_id);
                        
                        // Check if the statement execution is successful
                        if(!mysqli_stmt_execute($stmt)){
                            // If insertion fails, exit with an error message
                            echo "error=could not insert into dummies week=".$match_id." for shooter=".$shooter_id.".";
                            exit();
                        } else {
                            // If insertion is successful, echo a success message
                            echo "Inserted week: ".$week." and shooter: ".$name." into dummy_shooters";
                        }
                    }
                } else {
                    // If no valid ids are retrieved, echo a message indicating no insertion
                    echo "No ids retrieved, so nothing inserted";
                }
            }
        } else {
            // Unset a dummy shooter
            $sql = "SELECT id FROM shooters WHERE display_name=?";
            $stmt = mysqli_stmt_init($conn);

            // Check if the SQL statement is prepared successfully
            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "error=".mysqli_error($conn);
                exit();
            } else {
                // Bind parameters and execute the statement
                mysqli_stmt_bind_param($stmt, "s", $name);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                // Fetch the result into an associative array
                if($row = mysqli_fetch_assoc($result)){
                    $shooter_id = $row['id'];
                } else {
                    // If no shooter is found, exit with an error message
                    echo "error=no such shooter";
                    exit();
                }

                $sql = "DELETE FROM dummy_shooters WHERE shooter_id=? AND starting_match_id >= (SELECT start_date FROM seasons WHERE id = (SELECT MAX(id) FROM seasons))";
                $stmt = mysqli_stmt_init($conn);

                // Check if the SQL statement is prepared successfully
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "error=".mysqli_error($conn);
                    exit();
                } else {
                    // Bind parameters and execute the statement
                    mysqli_stmt_bind_param($stmt, "i", $shooter_id);
                    if(!mysqli_stmt_execute($stmt)){
                        echo "error=unable to delete shooter ".$name." from dummy-shooters";
                        exit();
                    } else {
                        echo "deleted shooter ".$name." from dummy-shooters";
                    }
                }
            }
        }
    }
?>