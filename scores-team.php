<?php
        echo '
            <table>
                <thead>
                    <tr></tr>
                    <tr>
                        <th scope="col" colspan="2" class="team-name"><h2>'.$name.'</h2></th>
                        <th scope="col"><h3>Wk 1</h3></th>
                        <th scope="col"><h3>Wk 2</h3></th>
                        <th scope="col"><h3>Wk 3</h3></th>
                        <th scope="col"><h3>Wk 4</h3></th>
                        <th scope="col"><h3>Wk 5</h3></th>
                        <th scope="col"><h3>Wk 6</h3></th>
                        <th scope="col"><h3>Wk 7</h3></th>
                        <th scope="col"><h3>Wk 8</h3></th>
                        <th scope="col"><h3>Wk 9</h3></th>
                        <th scope="col"><h3>Wk 10</h3></th>
                        <th scope="col"><h3>Wk 11</h3></th>
                        <th scope="col"><h3>Wk 12</h3></th>
                        <th scope="col"><h3>Wk 13</h3></th>
                        <th scope="col"><h3>Wk 14</h3></th>
                        <th scope="col"><h3>Wk 15</h3></th>
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
            if($s<6){
                require 'scores-ind.php';
                $s++;
            }
        }
        echo '
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>AGG</h3></th>
        ';
        foreach($numbers['wk_agg'] as $agg){
            echo'       <td>'.$agg.'</td>';
        }
        echo '
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>AGG AVG</h3></th>
        ';
        foreach($numbers['wk_agg_avg'] as $avg){
            echo '      <td>'.number_format($avg,1,'.','').'</td>';
        }
        echo '
                        <td colspan="2"></td>
                        <th scope="row"><h3>LYAA</h3></th>
                        <td>'.number_format($numbers['lyaas'],1,'.','').'</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>HANDICAP AVE.</h3></th>
        ';
        foreach($numbers['wk_hand_avg'] as $hand_avg){
            echo '      
                        <td>'.number_format($hand_avg,1,'.','').'</td>
            ';
        }
        echo '
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>HANDICAP</h3></th>
        ';
        foreach($numbers['wk_handicap'] as $hand){
            echo '
                        <td>'.$hand.'</td>
            ';
        }
        echo '
                        <td colspan="6"></td>
                    </tr>
                    <tr>					
                        <td></td>
                        <th scope="row"><h3>TOTAL</h3></th>
        ';
        foreach($numbers['wk_total'] as $total){
            echo '
                        <td>'.$total.'</td>
            ';
        }
        echo '
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>WINS=1</h3></th>
        ';
        foreach($numbers['wk_win'] as $win){
            echo '
                        <td>'.$win.'</td>
            ';
        }
        echo '
                        <td colspan="2"></td>
                        <th scope="row" colspan="2"><h3>TOTAL WINS</h3></th>
                        <td>'.$numbers['team_wins'].'</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>OP TEAM</h3></th>
        ';
        foreach($numbers['opp_teams'] as $team){
            echo '
                        <td>'.$team.'</td>
            ';
        }
        echo '
                        <td colspan="6"></td>
                    </tr>
                </tfoot>
            </table>
        ';
?>