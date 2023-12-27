<?php 
    if(isset($_POST)){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if(!is_null($data)){
            require "dbh.inc.php";
            $insertData = array();
            foreach($data as $key=>$value){
                $name = substr($key,0,strlen($key)-3);
                $week = substr($key,-2);
                if(array_key_exists($name,$insertData)){
                    $insertData[$name] += array($week => $value);
                } else {
                    $insertData += array($name=>array($week=>$value));
                }
            }
            echo 'received: '.$json.'; compiled: '.json_encode($insertData);
            foreach($insertData as $shooter=>$scores){
                $shooter_id = 0;
                $sql = "SELECT id FROM shooters WHERE display_name=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../".$_SESSION['page'].".php?error=".mysqli_error($conn));
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $shooter);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ($row = mysqli_fetch_assoc($result)) {
                        $shooter_id = $row['id'];
                        foreach($scores as $week=>$score){
                            $week_id = 0;
                            $sql = "SELECT id FROM matches WHERE match_num=? AND match_date >= (SELECT start_date FROM seasons WHERE id = (SELECT max(id) FROM seasons))";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                header("Location:../".$_SESSION['page'].".php?error=".mysqli_error($conn));
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "s", $week);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                if($row = mysqli_fetch_assoc($result)) {
                                    $week_id = $row['id'];
                                    if($score != ''){
                                        $sql = "SELECT id FROM scores WHERE shooter_id=? AND match_id=?";
                                        $stmt = mysqli_stmt_init($conn);
                                        if(!mysqli_stmt_prepare($stmt, $sql)){
                                            header("Location: ../".$_SESSION['page'].".php?error=".mysqli_error($conn));
                                            exit();
                                        } else {
                                            mysqli_stmt_bind_param($stmt, "ii", $shooter_id, $week_id);
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);
                                            if($row = mysqli_fetch_assoc($result)) {
                                                $sql = "UPDATE scores SET score=?, changed=1, created_at=now() WHERE shooter_id=? AND match_id=?";
                                                $stmt = mysqli_stmt_init($conn);
                                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                                    header("Location: ../".$_SESSION['page'].".php?error=".mysqli_error($conn));
                                                    exit();
                                                } else {
                                                    mysqli_stmt_bind_param($stmt, "iii", $score, $shooter_id, $week_id);
                                                    if(!mysqli_stmt_execute($stmt)){
                                                        header("Location: ../".$_SESSION['page'].".php?error=".mysqli_error($conn));
                                                        exit();
                                                    } else {
                                                        echo 'Updated week: '.$week.' score: '.$score.' for '.$shooter.'.';
                                                    }
                                                }
                                            } else {
                                                $sql = "INSERT INTO scores (shooter_id, match_id, score, changed, created_at) VALUES (?,?,?,0,now())";
                                                $stmt = mysqli_stmt_init($conn);
                                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                                    header("Location: ../".$_SESSION['page'].".php?error=".mysqli_error($conn));
                                                    exit();
                                                } else {
                                                    mysqli_stmt_bind_param($stmt, "iii", $shooter_id, $week_id, $score);
                                                    if(!mysqli_stmt_execute($stmt)){
                                                        header("Location: ../".$_SESSION['page'].".php?error=".mysqli_error($conn));
                                                        exit();
                                                    } else {
                                                        echo 'Inserted week: '.$week.' score: '.$score.' into '.$shooter.'.';
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        $sql = "DELETE FROM scores WHERE shooter_id=? AND match_id=?";
                                        $stmt = mysqli_stmt_init($conn);
                                        if(!mysqli_stmt_prepare($stmt, $sql)){
                                            header("Location: ../".$_SESSION['page'].".php?error=".mysqli_error($conn));
                                            exit();
                                        } else {
                                            mysqli_stmt_bind_param($stmt, "ii", $shooter_id, $match_id);
                                            if(!mysqli_stmt_execute($stmt)){
                                                header("Location: ../".$_SESSION['page'].".php?error=".mysqli_error($conn));
                                                exit();
                                            } else {
                                                echo 'Deleted week: '.$week.' score: '.$score.' for '.$shooter.'.';
                                            }
                                        }
                                    }
                                }
                            }

                        }
                    } else {
                        header("Location: ../".$_SESSION['page'].".php?error=".mysqli_error($conn));
                        exit();
                    }
                }
            }
        }
        header("Location: ../".$_SESSION['page'].".php?edit_success");
    }
?>