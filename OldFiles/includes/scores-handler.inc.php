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
// Verify the post comes from the right place
 if(!isset($_SESSION['page']) || $_SESSION['page'] != 'scores-edit' || !isset($_SESSION['executive']) || $_SESSION['executive'] != 'Statistician'){
    // Shouldn't be here, send them home
    header("Location: ../index.php");
    exit();
 }
    if(isset($_POST)){
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
                $sql = "SELECT id FROM shooters WHERE display_name=:display_name";
                $stmt = $con->prepare($sql);

                $stmt->bindParam(':display_name', $shooter, PDO::PARAM_STR);
                $stmt->execute();
                if($shooter_id = $stmt->fetchColumn()){

                    // Process and update scores for each week
                    foreach($scores as $week=>$score){
                        $week_id = 0;
                        
                        // Retrieve week ID from the database
                        $sql = "SELECT id FROM matches WHERE match_num=:match_num AND match_date >= (SELECT start_date FROM seasons WHERE id = (SELECT max(id) FROM seasons))";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':match_num', $week, PDO::PARAM_STR);
                        $stmt->execute();
                        if($week_id = $stmt->fetchColumn()){
                            // Update score if it exists
                            $sql = "SELECT id FROM scores WHERE shooter_id=:shooter_id AND match_id=:week_id";
                            $stmt = $conn->prepare($sql);

                            $stmt->bindParam(':shooter_id', $shooter_id, PDO::PARAM_INT);
                            $stmt->bindParam(':week_id', $week_id, PDO::PARAM_INT);
                            $stmt->execute();
                            if($score_id = $stmt->fetchColumn()){
                                if($score != ''){
                                    // Score exists, update it
                                    $sql = "UPDATE scores SET score=:score, changed=1, created_at=now() WHERE id=:score_id";
                                    $stmt = $conn->prepare($sql);

                                    $stmt->bindParam(':score', $score, PDO::PARAM_INT);
                                    $stmt->bindParam(':score_id', $score_id, PDO::PARAM_INT);
                                    
                                    if(!$stmt->execute()){
                                        echo "error=could not update ".$score." for ".$shooter." on week ".$week;
                                        exit();
                                    } else {
                                        echo 'Updated week: '.$week.' score: '.$score.' for '.$shooter.'.';
                                    }
                                } else {
                                    // Delete score if it exists
                                    $sql = "DELETE FROM scores WHERE score_id=:score_id";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':score_id', $score_id, PDO::PARAM_INT);
                                        
                                    if(!$stmt->execute()){
                                        echo "error=could not delete score for ".$shooter." on week ".$week;
                                        exit();
                                    } else {
                                        echo 'Deleted week: '.$week.' score for '.$shooter.'.';
                                    }
                                }
                            } elseif ($score != '') {
                                // Score does not exist, insert it
                                $sql = "INSERT INTO scores (shooter_id, match_id, score, changed, created_at) VALUES (:shooter_id,:week_id,:score,0,now())";
                                $stmt = $conn->prepare($sql);

                                $stmt->bindParam(':shooter_id', $shooter_id, PDO::PARAM_INT);
                                $stmt->bindParam(':week_id', $week_id, PDO::PARAM_INT);
                                $stmt->bindParam(':score', $score, PDO::PARAM_INT);

                                if(!$stmt->execute()){
                                    echo "error=could not insert ".$score." for ".$shooter." on week ".$week;
                                    exit();
                                } else {
                                    echo 'Inserted week: '.$week.' score: '.$score.' into '.$shooter.'.';
                                }
                            }
                        } else {
                            echo "error=could not retrieve id for week '".$week."'.";
                            exit();
                        }
                    }
                } else {
                    echo "error=could not retrieve id for '".$shooter."'.";
                    exit();
                }
            }
        }
    }
?>