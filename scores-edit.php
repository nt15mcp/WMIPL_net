<?php
// Need to start a new session if necessary and track what page we are on for this session 
session_start();
$_SESSION['page']="scores-edit";
require "header.php"; // Use common header file so no need to repeat for each page
if(isset($_SESSION['executive'])){
    if($_SESSION['executive']!='Statistician'){
        header("Location: scores.php".$urlString); // if statistician is not logged in, go to scores view page.
    }
}else{
    header("Location: scores.php".$urlString); // if statistician is not logged in, go to scores view page.
}

// bring in all the data!
require "includes/scores-edit.inc.php";
?>

<div class="scores-edit">
    <table class="w3-table">
        <thead>
            <tr>
                <th><h2>NUMBER</h2></th>
                <th><h2>NAME</h2></th>
                <?php
                    for($q=0;$q<3;$q++){
                        echo '<th class="qualifying"><h2>Q'.($q+1).'</h2></th>';
                    }
                    for($wk=0;$wk<15;$wk++){
                        echo '<th class="season"><h2>wk'.($wk+1).'</h2></th>';
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($divisions as $teams){
                    foreach($teams as $numbers){
                        $s=0;
                        $shooter = '';
                        foreach($numbers as $number=>$shooters){
                            if($s<6){
                                echo '
                                    <tr>
                                        <th><h3>'.$number.'</h3></th>
                                ';
                                if(!is_string($shooters)){
                                    foreach($shooters as $name=>$scores){
                                        $shooter = $name;
                                        echo '<th><h3>'.$name.'</th><h3>';
                                        break;
                                    }
                                    for($wk=1;$wk<4;$wk++){
                                        if(array_key_exists('Q'.$wk,$scores)){
                                            echo '<td>'.$scores['Q'.$wk][0].'</td>';
                                        } else {
                                            echo '<td></td>';
                                        }
                                    }
                                    for($wk=1;$wk<16;$wk++){
                                        if(array_key_exists($wk,$scores)){
                                            echo '<td>'.$scores[$wk][0].'</td>';
                                        } else {
                                            echo '<td></td>';
                                        }
                                    }
                                }else{
                                    echo '<th><h3>'.$shooters.'</th></h3>';
                                }
                                $s++;
                            }
                        }
                    }
                }
            ?>
        </tbody>
    </table>
</div>