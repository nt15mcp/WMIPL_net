<?php
    if(isset($_POST)){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if(!is_null($data)){
            require "dbh.inc.php";

            $team = $data["team"];
            $week = $data["week"];
            $team_id = 0;
            $week_id = 0;

            $sql = "SELECT id FROM teams WHERE name=?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "error=".mysqli_error($conn);
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $team);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if($row = mysqli_fetch_assoc($result)){
                    $team_id = $row['id'];
                } else {
                    echo "error=no such team";
                    exit();
                }
            }

            $sql = "SELECT id FROM matches WHERE match_num=? AND match_date >= (SELECT start_date FROM seasons WHERE id = (SELECT MAX(id) FROM seasons))";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "error=".mysqli_error($conn);
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "i", $week);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if($row = mysqli_fetch_assoc($result)){
                    $week_id = $row['id'];
                } else {
                    echo "error=no week found";
                    exit();
                }
            }

            if($team_id > 0 && $week_id > 0){
                $sql = "INSERT INTO tie_breaker_win (team_id, match_id) VALUES (?,?)";
                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "error=".mysqli_error($conn);
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "ii", $team_id, $week_id);
                    
                    if(!mysqli_stmt_execute($stmt)){
                        echo "error=could not insert into tie_breaker_win week=".$week_id." for team=".$team_id.".";
                        exit();
                    } else {
                        echo "Inserted week: ".$week." and team: ".$team." into tie_breaker_win";
                    }
                }
            } else {
                echo "No ids retrieved, so nothing inserted";
            }
        }
    }
?>