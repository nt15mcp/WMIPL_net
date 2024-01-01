<?php 
/**
 * Score Handling
 *
 * This script receives score data in JSON format, processes it, and updates the database accordingly.
 * It retrieves shooter and match information from the database, inserts or updates scores, and outputs
 * success or error messages. The script uses a common database login file (dbh.inc.php) for database connection.
 *
 * Note: The script expects a JSON payload in the format: {"shooter_week": "score", ...}
 *
 */
    if(isset($_SERVER["CONTENT_TYPE"])){
        // Get JSON data from the request
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if(!is_null($data)){
            require "dbh.inc.php"; // Use common database login file

            $insertData = array();

            // Process each item in the JSON data
            foreach($data as $key=>$value){
                $name = substr($key,0,strpos($key,"_"));
                $week = substr($key,strpos($key,"_")+1);

                // Compile data into a structured array
                if(array_key_exists($name,$insertData)){
                    $insertData[$name] += array($week => $value);
                } else {
                    $insertData += array($name=>array($week=>$value));
                }
            }

            // Output received and compiled data
            echo 'received: '.$json.'; compiled: '.json_encode($insertData).'\n';

            // Process and update database for each shooter
            foreach($insertData as $shooter=>$scores){
                $shooter_id = 0;

                // Retrieve shooter ID from the database
                $sql = "SELECT id FROM shooters WHERE display_name=?";
                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "error=".mysqli_error($conn);
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $shooter);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ($row = mysqli_fetch_assoc($result)) {
                        $shooter_id = $row['id'];
                        
                        // Process and update scores for each week
                        foreach($scores as $week=>$score){
                            $week_id = 0;
                            
                            // Retrieve week ID from the database
                            $sql = "SELECT id FROM matches WHERE match_num=? AND match_date >= (SELECT start_date FROM seasons WHERE id = (SELECT max(id) FROM seasons))";
                            $stmt = mysqli_stmt_init($conn);
                            
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                echo "error=".mysqli_error($conn);
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "s", $week);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if($row = mysqli_fetch_assoc($result)) {
                                    $week_id = $row['id'];

                                    if($score != ''){
                                        // Update score if it exists
                                        $sql = "SELECT id FROM scores WHERE shooter_id=? AND match_id=?";
                                        $stmt = mysqli_stmt_init($conn);

                                        if(!mysqli_stmt_prepare($stmt, $sql)){
                                            echo "error=".mysqli_error($conn);
                                            exit();
                                        } else {
                                            mysqli_stmt_bind_param($stmt, "ii", $shooter_id, $week_id);
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            if($row = mysqli_fetch_assoc($result)) {
                                                // Score exists, update it
                                                $sql = "UPDATE scores SET score=?, changed=1, created_at=now() WHERE shooter_id=? AND match_id=?";
                                                $stmt = mysqli_stmt_init($conn);

                                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                                    echo "error=".mysqli_error($conn);
                                                    exit();
                                                } else {
                                                    mysqli_stmt_bind_param($stmt, "iii", $score, $shooter_id, $week_id);
                                                    
                                                    if(!mysqli_stmt_execute($stmt)){
                                                        echo "error=could not update ".$score." for ".$shooter." on week ".$week;
                                                        exit();
                                                    } else {
                                                        echo 'Updated week: '.$week.' score: '.$score.' for '.$shooter.'.';
                                                    }
                                                }
                                            } else {
                                                // Score does not exist, insert it
                                                $sql = "INSERT INTO scores (shooter_id, match_id, score, changed, created_at) VALUES (?,?,?,0,now())";
                                                $stmt = mysqli_stmt_init($conn);

                                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                                    echo "error=".mysqli_error($conn);
                                                    exit();
                                                } else {
                                                    mysqli_stmt_bind_param($stmt, "iii", $shooter_id, $week_id, $score);

                                                    if(!mysqli_stmt_execute($stmt)){
                                                        echo "error=could not insert ".$score." for ".$shooter." on week ".$week;
                                                        exit();
                                                    } else {
                                                        echo 'Inserted week: '.$week.' score: '.$score.' into '.$shooter.'.';
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        // Delete score if it exists
                                        $sql = "DELETE FROM scores WHERE shooter_id=? AND match_id=?";
                                        $stmt = mysqli_stmt_init($conn);

                                        if(!mysqli_stmt_prepare($stmt, $sql)){
                                            echo "error=".mysqli_error($conn);
                                            exit();
                                        } else {
                                            mysqli_stmt_bind_param($stmt, "ii", $shooter_id, $week_id);
                                            
                                            if(!mysqli_stmt_execute($stmt)){
                                                echo "error=could not delete score for ".$shooter." on week ".$week;
                                                exit();
                                            } else {
                                                echo 'Deleted week: '.$week.' score for '.$shooter.'.';
                                            }
                                        }
                                    }
                                } else {
                                    echo "error=could not retrieve id for week '".$week."'.";
                                    exit();
                                }
                            }

                        }
                    } else {
                        echo "error=could not retrieve id for '".$shooter."'.";
                        exit();
                    }
                }
            }
        }
    }
?>