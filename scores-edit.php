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


<main>
<div>
        <button class="w3-button" onclick="submit()" >Submit</button>
</div>
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
                                                echo '<td><input name="'.$shooter.'_Q'.$wk.'" type="number" max="300" maxlength="3" step="1" width="4" defaultValue="'.$scores['Q'.$wk][0].'" value="'.$scores['Q'.$wk][0].'"></td>';
                                            } else {
                                                echo '<td><input name="'.$shooter.'_Q'.$wk.'" type="number" max="300" maxlength="3" step="1" width="4" defaultValue="" value=""></td>';
                                            }
                                        }
                                        for($wk=1;$wk<16;$wk++){
                                            if(array_key_exists($wk,$scores)){
                                                echo '<td><input name="'.$shooter.'_'.$wk.'" type="number" max="300" maxlength="3" step="1" width="4" defaultValue="'.$scores[$wk][0].'" value="'.$scores[$wk][0].'"></td>';
                                            } else {
                                                echo '<td><input name="'.$shooter.'_'.$wk.'" type="number" max="300" maxlength="3" step="1" width="4" defaultValue="" value=""></td>';
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
</main>
<script type="text/javascript">
    function submit(){
        let inputs = document.getElementsByTagName("input");
        var i;
        var changedInputs = new Object();
        for(i=0;i<inputs.length;i++){
            if(inputs[i].defaultValue != inputs[i].value){
                changedInputs[inputs[i].name] = inputs[i].value;
            }
        }
        if(Object.getOwnPropertyNames(changedInputs).length > 0){
            fetch("includes/scores-handler.inc.php", {
                "method": "POST",
                "headers": {"Content-type":"application/json"},
                "body": JSON.stringify(changedInputs)
            }).then(function(response){
                return response.text();
            }).then(function(data){
                console.log("Request complete! Response:", data);
            });
        }
    }
</script>