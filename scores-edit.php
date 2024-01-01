<?php
/**
 * Scores Edit Page
 *
 * PHP script for the scores edit page. Initiates a new session, sets the 'page'
 * session variable to 'scores-edit', and includes a common header file. Checks
 * if the logged-in user is an executive (specifically, a Statistician). If not,
 * redirects the user to the scores view page. Retrieves and displays editable
 * scores data for Qualifying and Season rounds in a table format. Allows
 * executives to submit score changes for individual shooters.
 *
 */

// Start a new session and track the current page
session_start();
$_SESSION['page']="scores-edit";

// Include a common header file to avoid repetition
require "header.php";

// Check if the logged-in user is an executive (Statistician)
if(isset($_SESSION['executive'])){
    if($_SESSION['executive']!='Statistician'){
        header("Location: scores.php".$urlString); // Redirect to scores view page
    }
}else{
    header("Location: scores.php".$urlString); // Redirect to scores view page
}

// Include scores edit data
require "includes/scores-edit.inc.php";
?>

<main>
<div class="button-container w3-center">
        <!-- Buttons for Submit, Reset, Show Qual, and Show Season -->
        <button class="w3-button w3-bar-item" onclick="submit()" >Submit</button>
        <button class="w3-button w3-bar-item" onclick="reset()" >Reset</button>
        <button class="w3-button w3-bar-item active" id="qual_view" onclick="qualifying()" >Show Qual</button>
        <button class="w3-button w3-bar-item active" id="season_view" onclick="season()">Show Season</button>
        <button class="w3-button w3-bar-item" onclick="declare_tie_breaker()" >Tie-Breaker Entry</button>
        <button class="w3-button w3-bar-item" onclick="make_shooter_swap()" >Shooter Swap</button>
</div>
    <div class="scores-edit">
        <!-- Table for displaying editable scores data -->
        <table class="w3-table">
            <thead>
                <tr>
                    <th class="headcol"><h2>NUMBER</h2></th>
                    <th class="headcol"><h2>NAME</h2></th>
                    <?php
                        // Display Qualifying and Season headers
                        for($q=0;$q<3;$q++){
                            echo '<th class="qualifying headrow"><h2>Q'.($q+1).'</h2></th>';
                        }
                        for($wk=0;$wk<15;$wk++){
                            echo '<th class="season headrow"><h2>Wk'.($wk+1).'</h2></th>';
                        }
                    ?>
                    <th class="headcol"><h2>DUMMY FUNCTION</h2></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $teams_arr = array();
                    $shooters_arr = array();
                    foreach($divisions as $teams){
                        foreach($teams as $team => $numbers){
                            $s=0;
                            $shooter = '';
                            array_push($teams_arr,$team);
                            foreach($numbers as $number=>$shooters){
                                if($s<6){
                                    echo '
                                        <tr>
                                            <th><h3>'.$number.'</h3></th>
                                    ';
                                    if(!is_string($shooters)){
                                        foreach($shooters as $name=>$scores){
                                            $shooter = $name;
                                            array_push($shooters_arr,$name);
                                            echo '<th><h3>'.$name.'</h3></th>';
                                            break;
                                        }
                                        for($wk=1;$wk<4;$wk++){
                                            if(array_key_exists('Q'.$wk,$scores)){
                                                echo '<td class="qualifying"><input name="'.$shooter.'_Q'.$wk.'" type="number" min="0" max="300" maxlength="3" step="1" width="3" defaultValue="'.$scores['Q'.$wk][0].'" value="'.$scores['Q'.$wk][0].'"></td>';
                                            } else {
                                                echo '<td class="qualifying"><input name="'.$shooter.'_Q'.$wk.'" type="number" min="0" max="300" maxlength="3" step="1" width="3" defaultValue="" value=""></td>';
                                            }
                                        }
                                        for($wk=1;$wk<16;$wk++){
                                            if(array_key_exists($wk,$scores)){
                                                echo '<td class="season"><input name="'.$shooter.'_'.$wk.'" type="number" min="0" max="300" maxlength="3" step="1" width="3" defaultValue="'.$scores[$wk][0].'" value="'.$scores[$wk][0].'"></td>';
                                            } else {
                                                echo '<td class="season"><input name="'.$shooter.'_'.$wk.'" type="number" min="0" max="300" maxlength="3" step="1" width="3" defaultValue="" value=""></td>';
                                            }
                                        }
                                        if(str_contains($shooter, 'DUMMY')){
                                            echo '<td><button class="w3-button" onclick="un_dummy_shooter(\''.$shooter.'\')" >UN-DUMMY</button></td>';
                                        } else {
                                            echo '<td><button class="w3-button" onclick="declare_dummy(\''.$shooter.'\')" >DUMMY</button></td>';
                                        }
                                    }else{
                                        $shooters_arr += $shooters;
                                        echo '<th><h3>'.$shooters.'</h3></th>';
                                        for($wk=1;$wk<4;$wk++){
                                            echo '<td class="qualifying"><input name="'.$shooters.'_Q'.$wk.'" type="number" min="0" max="300" maxlength="3" step="1" width="3" defaultValue="" value=""></td>';
                                        }
                                        for($wk=1;$wk<16;$wk++){
                                            echo '<td class="season"><input name="'.$shooters.'_'.$wk.'" type="number" min="0" max="300" maxlength="3" step="1" width="3" defaultValue="" value=""></td>';
                                        }
                                        if(str_contains($shooters, 'DUMMY')){
                                            echo '<td><button class="w3-button" onclick="un_dummy_shooter(\''.$shooters.'\')" >UN-DUMMY</button></td>';
                                        } else {
                                            echo '<td><button class="w3-button" onclick="declare_dummy(\''.$shooters.'\')" >DUMMY</button></td>';
                                        }
                                    }
                                    echo '</tr>';
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
<!-- Popup Window for Tie Breaker Selection -->
<container class="popup-window" id="tie-breaker-window">
    <h1>Select the Tie Breaker winner</h1>
    <br>
    <br>
    <!-- Dropdown for Choosing the Winning Team -->
    <label for="teams">Choose the winning team</label>
    <select id="teams" name="teams">
        <?php
            // Loop through teams array to populate options
            foreach($teams_arr as $team){
                echo '<option value="'.$team.'">'.$team.'</option>';
            }
        ?>
    </select>
    <br>
    <!-- Dropdown for Choosing the Week -->
    <label for="weeks">Choose the week</label>
    <select id="weeks" name="weeks">
        <?php
            // Loop through weeks (1 to 15) to populate options
            for($wk=1;$wk<16;$wk++){
                echo '<option value="'.$wk.'">'.$wk.'</option>';
            }
        ?>
    </select>
    <br>
    <!-- Submit and Cancel Buttons -->
    <button id="submit" onclick="submitTieBreaker()">Submit</button>
    <button id="cancel" onclick="close_tie_breaker()">Cancel</button>
</container>

<!-- Popup Window for Dummy Selection -->
<container class="popup-window" id="dummy-window">
    <h1 id="dummyHeader" name=""></h1>
    <br>
    <br>
    <input id="dummyInput" type="hidden" value=></input>
    <!-- Dropdown for Choosing the Week -->
    <label for="dummyWeeks">Choose the week</label>
    <select id="dummyWeeks" name="dummyWeeks">
        <?php
            // Loop through weeks (1 to 15) to populate options
            for($wk=1;$wk<16;$wk++){
                echo '<option value="'.$wk.'">'.$wk.'</option>';
            }
        ?>
    </select>
    <br>
    <!-- Submit and Cancel Buttons -->
    <button id="submit" onclick="submit_dummy('')">Submit</button>
    <button id="cancel" onclick="close_dummy()">Cancel</button>
</container>

<!-- Popup Window for Shooter Swap Selection -->
<container class="popup-window" id="swap-window">
    <h1>Select shooters and week for swap</h1>
    <br>
    <br>
    <label for="shooter1">Choose the first shooter</label>
    <select id="shooter1" name="shooter1">
        <?php
            // Loop through shooters to provide dropdown options
            foreach($shooters_arr as $name){
                echo '<option value="'.$name.'">'.$name.'</option>';
            }
        ?>
    </select>
    <br>
    <label for="shooter2">Choose the second shooter</label>
    <select id="shooter2" name="shooter2">
        <?php
            // Loop through shooters to provide dropdown options
            foreach($shooters_arr as $name){
                echo '<option value="'.$name.'">'.$name.'</option>';
            }
        ?>
    </select>
    <br>
    <!-- Dropdown for Choosing the Week -->
    <label for="swapWeeks">Choose the week</label>
    <select id="swapWeeks" name="swapWeeks">
    <?php
        // Loop through weeks (1 to 15) to populate options
        for($wk=1;$wk<16;$wk++){
            echo '<option value="'.$wk.'">'.$wk.'</option>';
        }
    ?>
    </select>
    <br>
    <!-- Submit and Cancel Buttons -->
    <button id="submit" onclick="submit_swap()">Submit</button>
    <button id="cancel" onclick="close_swap()">Cancel</button>
</container>

<?php 
    // Include scores handler for processing score changes
    include_once "includes/scores-handler.inc.php"; 
    // Include tie breaker handler for processing manual tie breakers
    include_once "includes/scores-tie-breaker.inc.php";
    // Include dummy handler for processing dummy shooters
    include_once "includes/scores-dummy.inc.php";
?>

<!-- JavaScript Section -->
<script type="text/javascript">
    /**
     * Function to submit changes to the server
     */
    function submit(){
        let inputs = document.getElementsByTagName("input");
        var i;
        var changedInputs = new Object();
        for(i=0;i<inputs.length;i++){
            // Check if input value has changed and is valid
            if(inputs[i].defaultValue != inputs[i].value && inputs[i].checkValidity()){
                changedInputs[inputs[i].name] = inputs[i].value;
            } else {
                // If not valid, reset to default value
                if(!inputs[i].checkValidity()){
                    inputs[i].value = inputs[i].defaultValue;
                }
            }
        }
        // If there are changed inputs, send them to the server
        if(Object.getOwnPropertyNames(changedInputs).length > 0){
            // Send changed inputs to the server using fetch API
            fetch("includes/scores-handler.inc.php", {
                "method": "POST",
                "headers": {"Content-type":"application/json"},
                "body": JSON.stringify(changedInputs)
            }).then(function(response){
                return response.text();
            }).then(function(data){
                console.log("Request complete! Response:", data);
                // Reload the page after successful submission
                location.reload();
            });
        }
    }

    /**
     * Function to reset all input values to default values
     */
    function reset(){
        // Reset all input values to their default values
        let inputs = document.getElementsByTagName("input");
        var i;
        for(i=0;i<inputs.length;i++){
            inputs[i].value = inputs[i].defaultValue;
        }
    }

    /**
     * Function to toggle visibility of Qualifying scores
     */
    function qualifying(){
        let qual = document.getElementById("qual_view");
        let quals = document.getElementsByClassName("qualifying");
        var i;
        if(qual.classList.contains("active")){
            qual.classList.remove("active");
            for(i=0;i<quals.length;i++){
                quals[i].classList.add("hide");
            }
        } else {
            qual.classList.add("active");
            for(i=0;i<quals.length;i++){
                quals[i].classList.remove("hide");
            }
        }
    }

    /**
     * Function to toggle visibility of Season scores
     */
    function season(){
        let season = document.getElementById("season_view");
        let seasons = document.getElementsByClassName("season");
        var i;
        if(season.classList.contains("active")){
            season.classList.remove("active");
            for(i=0;i<seasons.length;i++){
                seasons[i].classList.add("hide");
            }
        } else {
            season.classList.add("active");
            for(i=0;i<seasons.length;i++){
                seasons[i].classList.remove("hide");
            }
        }
    }

    // Get the elements by their ID
    const tie_breaker_Window = document.getElementById("tie-breaker-window");
    const dummy_window = document.getElementById("dummy-window");
    const swap_window = document.getElementById("swap-window");

     /**
     * Function to show the pop-up window when the link is clicked
     */
    function declare_tie_breaker(){
        tie_breaker_Window.style.display = "block";
    }
    function declare_dummy(name){
        var dummyHeader = document.getElementById("dummyHeader");
        var dummyInput = document.getElementById("dummyInput");
        var dummyString = "Select the Week to Dummy out: " + name;
        dummyHeader.textContent = dummyString;
        dummyInput.value = "'"+name+"'";
        dummy_window.style.display = "block";
    }
    function make_shooter_swap(){
        swap_window.style.display = "block";
    }

    /**
     * Function to hide the pop-up window when the close button is clicked
     */
    function close_tie_breaker(){
        tie_breaker_Window.style.display = "none";
    }
    function close_dummy(){
        dummy_window.style.display = "none";
    }
    function close_swap(){
        swap_window.style.display = "none";
    }
    
    /**
     * Function to submit tie breaker selection
     */
    function submitTieBreaker(){
        let team = document.getElementById("teams").value;
        let week = document.getElementById("weeks").value;

        // Send tie breaker selection to the server using fetch API
        fetch("includes/scores-tie-breaker.inc.php", {
                "method": "POST",
                "headers": {"Content-type":"application/json"},
                "body": JSON.stringify({"team": team,"week": week})
            }).then(function(response){
                return response.text();
            }).then(function(data){
                console.log("Request complete! Response:", data);
                // Close the pop-up window after successful submission
                close_tie_breaker();
            });
        }

    /**
     * Function to submit dummy shooter
     */
    function submit_dummy(name){
        if(name == ''){
            let newName = document.getElementById("dummyInput").value;
            let week = document.getElementById("dummyWeeks").value;

            // Send tie breaker selection to the server using fetch API
            fetch("includes/scores-dummy.inc.php", {
                    "method": "POST",
                    "headers": {"Content-type":"application/json"},
                    "body": JSON.stringify({"name": newName,"week": week})
                }).then(function(response){
                    return response.text();
                }).then(function(data){
                    console.log("Request complete! Response:", data);
                    // Reload the page to show new data
                    //location.reload();
                });
        } else {
            fetch("includes/scores-dummy.inc.php",{
                "method":"POST",
                "headers": {"Content-type":"application/json"},
                "body": JSON.stringify({"name": name, "week": ""})
            }).then(function(response){
                return response.text();
            }).then(function(data){
                console.log("Request complete! Response:", data);
                // Reload the page to show new data
                //location.reload();
            })
        }
    }
</script>