<?php
/**
 * Generates an HTML table with shooter information, scores, and statistics.
 *
 * This script constructs an HTML table to display detailed information about shooters,
 * their weekly scores, aggregates, averages, and various statistics for a team. The table
 * includes columns for each week, aggregate, number of weeks with positive scores, average score,
 * last year's average, class, and highest score. CSS classes are applied to indicate odd and even rows.
 */

// Start of PHP code block
    echo '
        <table class="w3-table">
            <thead>
            <!-- Table header row with columns for each week, aggregate, and various statistics -->
                <tr>
                    <!-- Team name column header -->
                    <th scope="col" colspan="2" class="team-name"><h2>'.$name.'</h2></th>
                    <!-- ... (column headers for each week) ... -->
                    <th scope="col"><h3>Wk1</h3></th>
                    <th scope="col"><h3>Wk2</h3></th>
                    <th scope="col"><h3>Wk3</h3></th>
                    <th scope="col"><h3>Wk4</h3></th>
                    <th scope="col"><h3>Wk5</h3></th>
                    <th scope="col"><h3>Wk6</h3></th>
                    <th scope="col"><h3>Wk7</h3></th>
                    <th scope="col"><h3>Wk8</h3></th>
                    <th scope="col"><h3>Wk9</h3></th>
                    <th scope="col"><h3>Wk10</h3></th>
                    <th scope="col"><h3>Wk11</h3></th>
                    <th scope="col"><h3>Wk12</h3></th>
                    <th scope="col"><h3>Wk13</h3></th>
                    <th scope="col"><h3>Wk14</h3></th>
                    <th scope="col"><h3>Wk15</h3></th>
                    <th scope="col"><h3>Agg</h3></th>
                    <th scope="col"><h3>Wks</h3></th>
                    <th scope="col"><h3>Avg</h3></th>
                    <th scope="col"><h3>LYA</h3></th>
                    <th scope="col"><h3>Cla</h3></th>
                    <th scope="col"><h3>High</h3></th>
                </tr>
            </thead>
            <tbody>
    ';
    $s=0;
    foreach($numbers as $number => $shooters){
        // Iterate through shooters and include additional score information
        if(is_numeric($number)){
            if($s<6){
                require 'scores-ind.php';
                // Include scores-ind.php for individual shooter scores
                $s++;
            }
        }
    }
    echo '
            </tbody>
            <tr class="empty-row"></tr>
            <tfoot>
                <!-- Footer rows with additional statistics -->
                <tr>
                    <!-- ... (footer columns for overall aggregate) ... -->
                    <td></td>
                    <th scope="row"><h3>AGG</h3></th>
    ';
    foreach($numbers['wk_agg'] as $agg){
        echo'       <td class="odd-row">'.$agg.'</td>';
    }
    echo '
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <!-- ... (footer columns for aggregate average, last year\'s average, and additional statistics) ... -->
                    <td></td>
                    <th scope="row"><h3>AGG AVG</h3></th>
    ';
    foreach($numbers['wk_agg_avg'] as $avg){
        echo '      <td class="even-row">'.number_format($avg,1,'.','').'</td>';
    }
    echo '
                    <td colspan="2"></td>
                    <!-- ... (location for the team\s last year aggregate of averages) .. -->
                    <th scope="row"><h3>LYAA:</h3></th>
                    <th><h3>'.number_format($numbers['lyaas'],1,'.','').'</h3></th>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <!-- ... (footer columns for handicap average) ... -->
                    <td></td>
                    <th scope="row"><h3>HANDICAP AVE.</h3></th>
    ';
    foreach($numbers['wk_hand_avg'] as $hand_avg){
        echo '      
                    <td class="odd-row">'.number_format($hand_avg,1,'.','').'</td>
        ';
    }
    echo '
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <!-- ... (footer columns for handicap values) ... -->
                    <td></td>
                    <th scope="row"><h3>HANDICAP</h3></th>
    ';
    foreach($numbers['wk_handicap'] as $hand){
        echo '
                    <td class="even-row">'.$hand.'</td>
        ';
    }
    echo '
                    <td colspan="6"></td>
                </tr>
                <tr>		
                    <!-- ... (footer columns for weekly totals including handicaps) ... -->			
                    <td></td>
                    <th scope="row"><h3>TOTAL</h3></th>
    ';
    foreach($numbers['wk_total'] as $total){
        echo '
                    <td class="odd-row">'.$total.'</td>
        ';
    }
    echo '
                    <td colspan="6"></td>
                </tr>
                <tr>		
                    <!-- ... (footer columns for weekly wins against opposing teams) ... -->		
                    <td></td>
                    <th scope="row"><h3>WINS=1</h3></th>
    ';
    foreach($numbers['wk_win'] as $win){
        echo '
                    <td class="even-row">'.$win.'</td>
        ';
    }
    echo '
                    <td colspan="2"></td>
                    <!-- ... (location for the total wins accumulated by this team) ... --->
                    <th scope="row" colspan="2"><h3>TOTAL WINS:</h3></th>
                    <th><h3>'.$numbers['team_wins'].'</h3></th>
                    <td></td>
                </tr>
                <tr>		
                    <!-- ... (footer columns for opposing team numbers) ... -->		
                    <td></td>
                    <th scope="row"><h3>OP TEAM</h3></th>
    ';
    foreach($numbers['opp_teams'] as $team){
        echo '
                    <td class="odd-row">'.$team.'</td>
        ';
    }
    echo '
                    <td colspan="6"></td>
                </tr>
            </tfoot>
        </table>
        <br>
        <br>
';
?>