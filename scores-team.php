<?php
    foreach($teams as $name=>$numbers){
        echo '
            <table>
                <thead>
                    <tr></tr>
                    <tr>
                        <th scope="col"><h2>'.$name.'</h2></th>
                        <th scope="col"></th>
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
        foreach($numbers as $number=>$name){
            foreach($name as $person=>$scores){
                require 'scores-ind.php';
            }
        }
        echo '
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>AGG</h3></th>
                        <td>wk1 agg</td>						
                        <td>wk2 agg</td>
                        <td>wk3 agg</td>
                        <td>wk4 agg</td>
                        <td>wk5 agg</td>
                        <td>wk6 agg</td>
                        <td>wk7 agg</td>
                        <td>wk8 agg</td>
                        <td>wk9 agg</td>
                        <td>wk10 agg</td>
                        <td>wk11 agg</td>
                        <td>wk12 agg</td>
                        <td>wk13 agg</td>
                        <td>wk14 agg</td>
                        <td>wk15 agg</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>AGG AVG</h3></th>
                        <td>wk1 agg ave</td>						
                        <td>wk2 agg ave</td>
                        <td>wk3 agg ave</td>
                        <td>wk4 agg ave</td>
                        <td>wk5 agg ave</td>
                        <td>wk6 agg ave</td>
                        <td>wk7 agg ave</td>
                        <td>wk8 agg ave</td>
                        <td>wk9 agg ave</td>
                        <td>wk10 agg ave</td>
                        <td>wk11 agg ave</td>
                        <td>wk12 agg ave</td>
                        <td>wk13 agg ave</td>
                        <td>wk14 agg ave</td>
                        <td>wk15 agg ave</td>
                        <td colspan="2"></td>
                        <th scope="row"><h3>LYAA</h3></th>
                        <td>LYAA val</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>HANDICAP AVE.</h3></th>
                        <td>wk1 handicap ave</td>						
                        <td>wk2 handicap ave</td>
                        <td>wk3 handicap ave</td>
                        <td>wk4 handicap ave</td>
                        <td>wk5 handicap ave</td>
                        <td>wk6 handicap ave</td>
                        <td>wk7 handicap ave</td>
                        <td>wk8 handicap ave</td>
                        <td>wk9 handicap ave</td>
                        <td>wk10 handicap ave</td>
                        <td>wk11 handicap ave</td>
                        <td>wk12 handicap ave</td>
                        <td>wk13 handicap ave</td>
                        <td>wk14 handicap ave</td>
                        <td>wk15 handicap ave</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>HANDICAP</h3></th>
                        <td>wk1 handicap</td>						
                        <td>wk2 handicap</td>
                        <td>wk3 handicap</td>
                        <td>wk4 handicap</td>
                        <td>wk5 handicap</td>
                        <td>wk6 handicap</td>
                        <td>wk7 handicap</td>
                        <td>wk8 handicap</td>
                        <td>wk9 handicap</td>
                        <td>wk10 handicap</td>
                        <td>wk11 handicap</td>
                        <td>wk12 handicap</td>
                        <td>wk13 handicap</td>
                        <td>wk14 handicap</td>
                        <td>wk15 handicap</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>					
                        <td></td>
                        <th scope="row"><h3>TOTAL</h3></th>
                        <td>wk1 total</td>						
                        <td>wk2 total</td>
                        <td>wk3 total</td>
                        <td>wk4 total</td>
                        <td>wk5 total</td>
                        <td>wk6 total</td>
                        <td>wk7 total</td>
                        <td>wk8 total</td>
                        <td>wk9 total</td>
                        <td>wk10 total</td>
                        <td>wk11 total</td>
                        <td>wk12 total</td>
                        <td>wk13 total</td>
                        <td>wk14 total</td>
                        <td>wk15 total</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>WINS=1</h3></th>
                        <td>wk1 win</td>						
                        <td>wk2 win</td>
                        <td>wk3 win</td>
                        <td>wk4 win</td>
                        <td>wk5 win</td>
                        <td>wk6 win</td>
                        <td>wk7 win</td>
                        <td>wk8 win</td>
                        <td>wk9 win</td>
                        <td>wk10 win</td>
                        <td>wk11 win</td>
                        <td>wk12 win</td>
                        <td>wk13 win</td>
                        <td>wk14 win</td>
                        <td>wk15 win</td>
                        <td colspan="2"></td>
                        <th scope="row" colspan="2"><h3>TOTAL WINS</h3></th>
                        <td>sum of wins</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>OP TEAM</h3></th>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td colspan="6"></td>
                    </tr>
                </tfoot>
            </table>
            <br>
            <table>
                <thead>
                    <tr></tr>
                    <tr>
                        <th scope="col"><h2>Team 2 Name</h2></th>
                        <th scope="col"></th>
                        <th scope="col"><h3>Week 1</h3></th>
                        <th scope="col"><h3>Week 2</h3></th>
                        <th scope="col"><h3>Week 3</h3></th>
                        <th scope="col"><h3>Week 4</h3></th>
                        <th scope="col"><h3>Week 5</h3></th>
                        <th scope="col"><h3>Week 6</h3></th>
                        <th scope="col"><h3>Week 7</h3></th>
                        <th scope="col"><h3>Week 8</h3></th>
                        <th scope="col"><h3>Week 9</h3></th>
                        <th scope="col"><h3>Week 10</h3></th>
                        <th scope="col"><h3>Week 11</h3></th>
                        <th scope="col"><h3>Week 12</h3></th>
                        <th scope="col"><h3>Week 13</h3></th>
                        <th scope="col"><h3>Week 14</h3></th>
                        <th scope="col"><h3>Week 15</h3></th>
                        <th scope="col"><h3>Aggregate</h3></th>
                        <th scope="col"><h3>Matches Completed</h3></th>
                        <th scope="col"><h3>Average</h3></th>
                        <th scope="col"><h3>Last Year Average</h3></th>
                        <th scope="col"><h3>Class</h3></th>
                        <th scope="col"><h3>High Score</h3></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>120</td>
                        <td>Name 1</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                        <td>121</td>
                        <td>Name 2</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    <tr>
                        <td>122</td>
                        <td>Name 3</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                    <tr>
                        <td>123</td>
                        <td>Name 4</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                    <tr>
                        <td>124</td>
                        <td>Name 5</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                    <tr>
                        <td>125</td>
                        <td>Name 6</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>AGG</h3></th>
                        <td>wk1 agg</td>						
                        <td>wk2 agg</td>
                        <td>wk3 agg</td>
                        <td>wk4 agg</td>
                        <td>wk5 agg</td>
                        <td>wk6 agg</td>
                        <td>wk7 agg</td>
                        <td>wk8 agg</td>
                        <td>wk9 agg</td>
                        <td>wk10 agg</td>
                        <td>wk11 agg</td>
                        <td>wk12 agg</td>
                        <td>wk13 agg</td>
                        <td>wk14 agg</td>
                        <td>wk15 agg</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>AGG AVG</h3></th>
                        <td>wk1 agg ave</td>						
                        <td>wk2 agg ave</td>
                        <td>wk3 agg ave</td>
                        <td>wk4 agg ave</td>
                        <td>wk5 agg ave</td>
                        <td>wk6 agg ave</td>
                        <td>wk7 agg ave</td>
                        <td>wk8 agg ave</td>
                        <td>wk9 agg ave</td>
                        <td>wk10 agg ave</td>
                        <td>wk11 agg ave</td>
                        <td>wk12 agg ave</td>
                        <td>wk13 agg ave</td>
                        <td>wk14 agg ave</td>
                        <td>wk15 agg ave</td>
                        <td colspan="2"></td>
                        <th scope="row"><h3>LYAA</h3></th>
                        <td>LYAA val</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>HANDICAP AVE.</h3></th>
                        <td>wk1 handicap ave</td>						
                        <td>wk2 handicap ave</td>
                        <td>wk3 handicap ave</td>
                        <td>wk4 handicap ave</td>
                        <td>wk5 handicap ave</td>
                        <td>wk6 handicap ave</td>
                        <td>wk7 handicap ave</td>
                        <td>wk8 handicap ave</td>
                        <td>wk9 handicap ave</td>
                        <td>wk10 handicap ave</td>
                        <td>wk11 handicap ave</td>
                        <td>wk12 handicap ave</td>
                        <td>wk13 handicap ave</td>
                        <td>wk14 handicap ave</td>
                        <td>wk15 handicap ave</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>HANDICAP</h3></th>
                        <td>wk1 handicap</td>						
                        <td>wk2 handicap</td>
                        <td>wk3 handicap</td>
                        <td>wk4 handicap</td>
                        <td>wk5 handicap</td>
                        <td>wk6 handicap</td>
                        <td>wk7 handicap</td>
                        <td>wk8 handicap</td>
                        <td>wk9 handicap</td>
                        <td>wk10 handicap</td>
                        <td>wk11 handicap</td>
                        <td>wk12 handicap</td>
                        <td>wk13 handicap</td>
                        <td>wk14 handicap</td>
                        <td>wk15 handicap</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>					
                        <td></td>
                        <th scope="row"><h3>TOTAL</h3></th>
                        <td>wk1 total</td>						
                        <td>wk2 total</td>
                        <td>wk3 total</td>
                        <td>wk4 total</td>
                        <td>wk5 total</td>
                        <td>wk6 total</td>
                        <td>wk7 total</td>
                        <td>wk8 total</td>
                        <td>wk9 total</td>
                        <td>wk10 total</td>
                        <td>wk11 total</td>
                        <td>wk12 total</td>
                        <td>wk13 total</td>
                        <td>wk14 total</td>
                        <td>wk15 total</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>WINS=1</h3></th>
                        <td>wk1 win</td>						
                        <td>wk2 win</td>
                        <td>wk3 win</td>
                        <td>wk4 win</td>
                        <td>wk5 win</td>
                        <td>wk6 win</td>
                        <td>wk7 win</td>
                        <td>wk8 win</td>
                        <td>wk9 win</td>
                        <td>wk10 win</td>
                        <td>wk11 win</td>
                        <td>wk12 win</td>
                        <td>wk13 win</td>
                        <td>wk14 win</td>
                        <td>wk15 win</td>
                        <td colspan="2"></td>
                        <th scope="row" colspan="2"><h3>TOTAL WINS</h3></th>
                        <td>sum of wins</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>OP TEAM</h3></th>
                        <td>1</td>
                        <td>4</td>
                        <td>3</td>
                        <td>1</td>
                        <td>4</td>
                        <td>3</td>
                        <td>1</td>
                        <td>4</td>
                        <td>3</td>
                        <td>1</td>
                        <td>4</td>
                        <td>3</td>
                        <td>1</td>
                        <td>4</td>
                        <td>3</td>
                        <td colspan="6"></td>
                    </tr>
                </tfoot>
            </table>
            <br>
            <table>
                <thead>
                    <tr></tr>
                    <tr>
                        <th scope="col"><h2>Team 3 Name</h2></th>
                        <th scope="col"></th>
                        <th scope="col"><h3>Week 1</h3></th>
                        <th scope="col"><h3>Week 2</h3></th>
                        <th scope="col"><h3>Week 3</h3></th>
                        <th scope="col"><h3>Week 4</h3></th>
                        <th scope="col"><h3>Week 5</h3></th>
                        <th scope="col"><h3>Week 6</h3></th>
                        <th scope="col"><h3>Week 7</h3></th>
                        <th scope="col"><h3>Week 8</h3></th>
                        <th scope="col"><h3>Week 9</h3></th>
                        <th scope="col"><h3>Week 10</h3></th>
                        <th scope="col"><h3>Week 11</h3></th>
                        <th scope="col"><h3>Week 12</h3></th>
                        <th scope="col"><h3>Week 13</h3></th>
                        <th scope="col"><h3>Week 14</h3></th>
                        <th scope="col"><h3>Week 15</h3></th>
                        <th scope="col"><h3>Aggregate</h3></th>
                        <th scope="col"><h3>Matches Completed</h3></th>
                        <th scope="col"><h3>Average</h3></th>
                        <th scope="col"><h3>Last Year Average</h3></th>
                        <th scope="col"><h3>Class</h3></th>
                        <th scope="col"><h3>High Score</h3></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>130</td>
                        <td>Name 1</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                        <td>131</td>
                        <td>Name 2</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    <tr>
                        <td>132</td>
                        <td>Name 3</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                    <tr>
                        <td>133</td>
                        <td>Name 4</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                    <tr>
                        <td>134</td>
                        <td>Name 5</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                    <tr>
                        <td>135</td>
                        <td>Name 6</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>AGG</h3></th>
                        <td>wk1 agg</td>						
                        <td>wk2 agg</td>
                        <td>wk3 agg</td>
                        <td>wk4 agg</td>
                        <td>wk5 agg</td>
                        <td>wk6 agg</td>
                        <td>wk7 agg</td>
                        <td>wk8 agg</td>
                        <td>wk9 agg</td>
                        <td>wk10 agg</td>
                        <td>wk11 agg</td>
                        <td>wk12 agg</td>
                        <td>wk13 agg</td>
                        <td>wk14 agg</td>
                        <td>wk15 agg</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>AGG AVG</h3></th>
                        <td>wk1 agg ave</td>						
                        <td>wk2 agg ave</td>
                        <td>wk3 agg ave</td>
                        <td>wk4 agg ave</td>
                        <td>wk5 agg ave</td>
                        <td>wk6 agg ave</td>
                        <td>wk7 agg ave</td>
                        <td>wk8 agg ave</td>
                        <td>wk9 agg ave</td>
                        <td>wk10 agg ave</td>
                        <td>wk11 agg ave</td>
                        <td>wk12 agg ave</td>
                        <td>wk13 agg ave</td>
                        <td>wk14 agg ave</td>
                        <td>wk15 agg ave</td>
                        <td colspan="2"></td>
                        <th scope="row"><h3>LYAA</h3></th>
                        <td>LYAA val</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>HANDICAP AVE.</h3></th>
                        <td>wk1 handicap ave</td>						
                        <td>wk2 handicap ave</td>
                        <td>wk3 handicap ave</td>
                        <td>wk4 handicap ave</td>
                        <td>wk5 handicap ave</td>
                        <td>wk6 handicap ave</td>
                        <td>wk7 handicap ave</td>
                        <td>wk8 handicap ave</td>
                        <td>wk9 handicap ave</td>
                        <td>wk10 handicap ave</td>
                        <td>wk11 handicap ave</td>
                        <td>wk12 handicap ave</td>
                        <td>wk13 handicap ave</td>
                        <td>wk14 handicap ave</td>
                        <td>wk15 handicap ave</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>HANDICAP</h3></th>
                        <td>wk1 handicap</td>						
                        <td>wk2 handicap</td>
                        <td>wk3 handicap</td>
                        <td>wk4 handicap</td>
                        <td>wk5 handicap</td>
                        <td>wk6 handicap</td>
                        <td>wk7 handicap</td>
                        <td>wk8 handicap</td>
                        <td>wk9 handicap</td>
                        <td>wk10 handicap</td>
                        <td>wk11 handicap</td>
                        <td>wk12 handicap</td>
                        <td>wk13 handicap</td>
                        <td>wk14 handicap</td>
                        <td>wk15 handicap</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>					
                        <td></td>
                        <th scope="row"><h3>TOTAL</h3></th>
                        <td>wk1 total</td>						
                        <td>wk2 total</td>
                        <td>wk3 total</td>
                        <td>wk4 total</td>
                        <td>wk5 total</td>
                        <td>wk6 total</td>
                        <td>wk7 total</td>
                        <td>wk8 total</td>
                        <td>wk9 total</td>
                        <td>wk10 total</td>
                        <td>wk11 total</td>
                        <td>wk12 total</td>
                        <td>wk13 total</td>
                        <td>wk14 total</td>
                        <td>wk15 total</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>WINS=1</h3></th>
                        <td>wk1 win</td>						
                        <td>wk2 win</td>
                        <td>wk3 win</td>
                        <td>wk4 win</td>
                        <td>wk5 win</td>
                        <td>wk6 win</td>
                        <td>wk7 win</td>
                        <td>wk8 win</td>
                        <td>wk9 win</td>
                        <td>wk10 win</td>
                        <td>wk11 win</td>
                        <td>wk12 win</td>
                        <td>wk13 win</td>
                        <td>wk14 win</td>
                        <td>wk15 win</td>
                        <td colspan="2"></td>
                        <th scope="row" colspan="2"><h3>TOTAL WINS</h3></th>
                        <td>sum of wins</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>OP TEAM</h3></th>
                        <td>4</td>
                        <td>1</td>
                        <td>2</td>
                        <td>4</td>
                        <td>1</td>
                        <td>2</td>
                        <td>4</td>
                        <td>1</td>
                        <td>2</td>
                        <td>4</td>
                        <td>1</td>
                        <td>2</td>
                        <td>4</td>
                        <td>1</td>
                        <td>2</td>
                        <td colspan="6"></td>
                    </tr>
                </tfoot>
            </table>
            <br>
            <table>
                <thead>
                    <tr></tr>
                    <tr>
                        <th scope="col"><h2>Team 4 Name</h2></th>
                        <th scope="col"></th>
                        <th scope="col"><h3>Week 1</h3></th>
                        <th scope="col"><h3>Week 2</h3></th>
                        <th scope="col"><h3>Week 3</h3></th>
                        <th scope="col"><h3>Week 4</h3></th>
                        <th scope="col"><h3>Week 5</h3></th>
                        <th scope="col"><h3>Week 6</h3></th>
                        <th scope="col"><h3>Week 7</h3></th>
                        <th scope="col"><h3>Week 8</h3></th>
                        <th scope="col"><h3>Week 9</h3></th>
                        <th scope="col"><h3>Week 10</h3></th>
                        <th scope="col"><h3>Week 11</h3></th>
                        <th scope="col"><h3>Week 12</h3></th>
                        <th scope="col"><h3>Week 13</h3></th>
                        <th scope="col"><h3>Week 14</h3></th>
                        <th scope="col"><h3>Week 15</h3></th>
                        <th scope="col"><h3>Aggregate</h3></th>
                        <th scope="col"><h3>Matches Completed</h3></th>
                        <th scope="col"><h3>Average</h3></th>
                        <th scope="col"><h3>Last Year Average</h3></th>
                        <th scope="col"><h3>Class</h3></th>
                        <th scope="col"><h3>High Score</h3></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>140</td>
                        <td>Name 1</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                        <td>141</td>
                        <td>Name 2</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    <tr>
                        <td>142</td>
                        <td>Name 3</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                    <tr>
                        <td>143</td>
                        <td>Name 4</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                    <tr>
                        <td>144</td>
                        <td>Name 5</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                    <tr>
                        <td>145</td>
                        <td>Name 6</td>
                        <td>wk1 score</td>
                        <td>wk2 score</td>
                        <td>wk3 score</td>
                        <td>wk4 score</td>
                        <td>wk5 score</td>
                        <td>wk6 score</td>
                        <td>wk7 score</td>
                        <td>wk8 score</td>
                        <td>wk9 score</td>
                        <td>wk10 score</td>
                        <td>wk11 score</td>
                        <td>wk12 score</td>
                        <td>wk13 score</td>
                        <td>wk14 score</td>
                        <td>wk15 score</td>
                        <td>agg</td>
                        <td>wks</td>
                        <td>avg</td>
                        <td>lya</td>
                        <td>cl</td>
                        <td>high</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>AGG</h3></th>
                        <td>wk1 agg</td>						
                        <td>wk2 agg</td>
                        <td>wk3 agg</td>
                        <td>wk4 agg</td>
                        <td>wk5 agg</td>
                        <td>wk6 agg</td>
                        <td>wk7 agg</td>
                        <td>wk8 agg</td>
                        <td>wk9 agg</td>
                        <td>wk10 agg</td>
                        <td>wk11 agg</td>
                        <td>wk12 agg</td>
                        <td>wk13 agg</td>
                        <td>wk14 agg</td>
                        <td>wk15 agg</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>AGG AVG</h3></th>
                        <td>wk1 agg ave</td>						
                        <td>wk2 agg ave</td>
                        <td>wk3 agg ave</td>
                        <td>wk4 agg ave</td>
                        <td>wk5 agg ave</td>
                        <td>wk6 agg ave</td>
                        <td>wk7 agg ave</td>
                        <td>wk8 agg ave</td>
                        <td>wk9 agg ave</td>
                        <td>wk10 agg ave</td>
                        <td>wk11 agg ave</td>
                        <td>wk12 agg ave</td>
                        <td>wk13 agg ave</td>
                        <td>wk14 agg ave</td>
                        <td>wk15 agg ave</td>
                        <td colspan="2"></td>
                        <th scope="row"><h3>LYAA</h3></th>
                        <td>LYAA val</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>HANDICAP AVE.</h3></th>
                        <td>wk1 handicap ave</td>						
                        <td>wk2 handicap ave</td>
                        <td>wk3 handicap ave</td>
                        <td>wk4 handicap ave</td>
                        <td>wk5 handicap ave</td>
                        <td>wk6 handicap ave</td>
                        <td>wk7 handicap ave</td>
                        <td>wk8 handicap ave</td>
                        <td>wk9 handicap ave</td>
                        <td>wk10 handicap ave</td>
                        <td>wk11 handicap ave</td>
                        <td>wk12 handicap ave</td>
                        <td>wk13 handicap ave</td>
                        <td>wk14 handicap ave</td>
                        <td>wk15 handicap ave</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>HANDICAP</h3></th>
                        <td>wk1 handicap</td>						
                        <td>wk2 handicap</td>
                        <td>wk3 handicap</td>
                        <td>wk4 handicap</td>
                        <td>wk5 handicap</td>
                        <td>wk6 handicap</td>
                        <td>wk7 handicap</td>
                        <td>wk8 handicap</td>
                        <td>wk9 handicap</td>
                        <td>wk10 handicap</td>
                        <td>wk11 handicap</td>
                        <td>wk12 handicap</td>
                        <td>wk13 handicap</td>
                        <td>wk14 handicap</td>
                        <td>wk15 handicap</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>					
                        <td></td>
                        <th scope="row"><h3>TOTAL</h3></th>
                        <td>wk1 total</td>						
                        <td>wk2 total</td>
                        <td>wk3 total</td>
                        <td>wk4 total</td>
                        <td>wk5 total</td>
                        <td>wk6 total</td>
                        <td>wk7 total</td>
                        <td>wk8 total</td>
                        <td>wk9 total</td>
                        <td>wk10 total</td>
                        <td>wk11 total</td>
                        <td>wk12 total</td>
                        <td>wk13 total</td>
                        <td>wk14 total</td>
                        <td>wk15 total</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>WINS=1</h3></th>
                        <td>wk1 win</td>						
                        <td>wk2 win</td>
                        <td>wk3 win</td>
                        <td>wk4 win</td>
                        <td>wk5 win</td>
                        <td>wk6 win</td>
                        <td>wk7 win</td>
                        <td>wk8 win</td>
                        <td>wk9 win</td>
                        <td>wk10 win</td>
                        <td>wk11 win</td>
                        <td>wk12 win</td>
                        <td>wk13 win</td>
                        <td>wk14 win</td>
                        <td>wk15 win</td>
                        <td colspan="2"></td>
                        <th scope="row" colspan="2"><h3>TOTAL WINS</h3></th>
                        <td>sum of wins</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"><h3>OP TEAM</h3></th>
                        <td>3</td>
                        <td>2</td>
                        <td>1</td>
                        <td>3</td>
                        <td>2</td>
                        <td>1</td>
                        <td>3</td>
                        <td>2</td>
                        <td>1</td>
                        <td>3</td>
                        <td>2</td>
                        <td>1</td>
                        <td>3</td>
                        <td>2</td>
                        <td>1</td>
                        <td colspan="6"></td>
                    </tr>
                </tfoot>
        </table> 
        ';
    }
?>