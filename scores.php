<?php
	// Need to start a new session if necessary and track what page we are on for this session 
	session_start();
	$_SESSION['page']="scores";
	require "header.php"; // Use common header file so no need to repeat for each page
?>

	<main>
		<div>
			<!-- Setup a selection box bar across the top of the page to select divisions for viewing -->
			<div class="w3-bar w3-center w3-border w3-blue">
				<label class="w3-text-black w3-bar-item">Select to View In Page</label>
				<div class="w3-bar-item">
					<input id="divAChk" type="checkbox" label="Division A" value="false"><label>Division A</label>
				</div>
				<div class="w3-bar-item">
					<input id="divBChk" type="checkbox" label="Division B" value="false"><label>Division B</label>
				</div>
				<div class="w3-bar-item">
					<input id="divCChk" type="checkbox" label="Division C" value="false"><label>Division C</label>
				</div>
				<div class="w3-bar-item">
					<input id="divDChk" type="checkbox" label="Division D" value="false"><label>Division D</label>
				</div>
				<div class="w3-bar-item">
					<input id="divEChk" type="checkbox" label="Division E" value="false"><label>Division E</label>
				</div>
				<div class="w3-bar-item">
					<input id="divFChk" type="checkbox" label="Division F" value="false"><label>Division F</label>
				</div>
				
				<!-- Remove unused divisions -->
				<!--
				<div class="w3-bar-item">
					<input id="divGChk" type="checkbox" label="Division G" value="false"><label>Division G</label>
				</div>
				<div class="w3-bar-item">
					<input id="unassChk" type="checkbox" label="Unassigned" value="false"><label>Unassigned</label>
				</div>
				-->
				
				<div class="w3-bar-item">
					<input id="selectAllChk" type="checkbox" label="Select/Deselect All" value="true"><label>Select/Deselect All</label>
				</div>
				
			</div>
		</div>
		<!-- create iframes for each division viewing the associated Google Scheet -->
		<div class="w3-wide w3-center" id="DivA" style="display:none;padding:10px">
			<table>
				<thead>
					<tr>
						<th colspan="3"><h1>Division A</h1></th>						
					</tr>
				</thead>
			</table>
			<br>
			<table>
				<thead>
					<tr></tr>
					<tr>
						<th scope="col"><h2>Team 1 Name</h2></th>
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
						<td>110</td>
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
						<td>111</td>
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
						<td>112</td>
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
						<td>113</td>
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
						<td>114</td>
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
						<td>115</td>
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
		</div>
		<div class="w3-wide w3-center" id="DivB" style="display:none;padding:10px">
			<iframe title="Division B" width="100%" height="1250px" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQemizoT8FlG2Zu5mhmC9N3SfNxocPtv8nmrw72NgiIKMufXrS_FSvbztEhsRfn93d1H9tlkZ4v_RYZ/pubhtml?widget=false&amp;amp;headers=false"></iframe>
		</div>
		<div class="w3-wide w3-center" id="DivC" style="display:none;padding:10px">
			<iframe title="Division C" width="100%" height="1250px" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vSyhD3X-Vmdm_BnEwjv1RRaMdhI7--HvElppwY1Mv77IrlwE6wM4bk0Unx-Y5icHBbYbQCHX-jly0Sp/pubhtml?widget=false&amp;amp;headers=false"></iframe>
		</div>
		<div class="w3-wide w3-center" id="DivD" style="display:none;padding:10px">
			<iframe title="Division D" width="100%" height="1250px" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vTNDWY3v8gj3hoexXri7GDr3Uctpu4e77PqGAGxiLfbE0goZvHJs3n4skj5QmRfMdEoHIeb6DWqmq-z/pubhtml?widget=false&amp;amp;headers=false"></iframe>
		</div>
		<div class="w3-wide w3-center" id="DivE" style="display:none;padding:10px">
			<iframe title="Division E" width="100%" height="1250px" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vSer_vzB8BuUGfBzBMPL9gtW6XrIuluWf5l_N1_bVhROcmDwWRmGp8jnRX24vQ5IfXcZ8OfbmEmtT9J/pubhtml?widget=false&amp;amp;headers=false"></iframe>
		</div>
		<div class="w3-wide w3-center" id="DivF" style="display:none;padding:10px">
			<iframe title="Division F" width="100%" height="1250px" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vSwv4SihvTqVauukGrszDaRT0WUDpWUxe4mr1S6Ktci9d3eUVtyUfi3O8tgy7xKtrtYXFunVaLYCGRv/pubhtml?widget=false&amp;amp;headers=false"></iframe>
		</div>
		<div class="w3-wide w3-center" id="DivG" style="display:none;padding:10px">
			<iframe title="Division G" width="100%" height="1250px" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vSnfe5vKt-Auip34TtmNcU9HGGbsUMhuoqxfuhxqweqB6k2y7xyast2lXGZYmi7nVUSc3rJcQCzP4Iz/pubhtml?widget=false&amp;amp;headers=false"></iframe>
		</div>
		<div class="w3-wide w3-center" id="Unass" style="display:none;padding:10px">
			<iframe title="Unassigned" width="100%" height="1250px" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vSVIBBt7gQ_xyP2uYuNT4ICk95UgNXFLK0ZKz5vBNHf0kP-8Cmjqvw5O7fqj1SOuitYSK2ksAIJwkWJ/pubhtml?widget=false&amp;headers=false"></iframe>
		</div>
		<!-- Dynamically update the displayed iframes based on the status of the checkboxes -->
		<script type="text/javascript">
			// Create a constant for each checkbox
			const divAChkbox = document.getElementById('divAChk');
			const divBChkbox = document.getElementById('divBChk');
			const divCChkbox = document.getElementById('divCChk');
			const divDChkbox = document.getElementById('divDChk');
			const divEChkbox = document.getElementById('divEChk');
			const divFChkbox = document.getElementById('divFChk');
			const divGChkbox = document.getElementById('divGChk');
			const unassChkbox = document.getElementById('unassChk');
			const selectAllChkbox = document.getElementById('selectAllChk');
			// Create an array of the checkboxes
			const divCheckboxes = [divAChkbox, divBChkbox, divCChkbox, divDChkbox, divEChkbox, divFChkbox];
			// Create a constant for each iFrame
			const divA = document.getElementById('DivA');
			const divB = document.getElementById('DivB');
			const divC = document.getElementById('DivC');
			const divD = document.getElementById('DivD');
			const divE = document.getElementById('DivE')
			const divF = document.getElementById('DivF');
			const divG = document.getElementById('DivG');
			const unass = document.getElementById('Unass');
			// Create an array of the iframes
			const divFrames = [divA, divB, divC, divD, divE, divF];
			// Create a variable of the visible iframes
			var chkboxCount = 0;
			// Listen for the checkbox state to change
			divCheckboxes.forEach((divCheckbox, index) => {
				// Add an event listener
				divCheckbox.addEventListener('change', (event) => {
					if (event.target.checked) {
						// Display the iFrame
						divFrames[index].style.display = 'block';
						// Add a count to the visible frames
						chkboxCount = chkboxCount + 1;
						//Determine if "Select All" should be checked
						if (chkboxCount == divFrames.length) {
							selectAllChkbox.checked = true;
						}
					} else {
						// Hide the iframe
						divFrames[index].style.display = 'none';
						// Decrement the count of visible frames
						chkboxCount = chkboxCount - 1;
						// Uncheck "Select All"
						if (selectAllChkbox.checked) {
							selectAllChkbox.checked = false;
						}
					}
				});
			});
			// Listen for the "Select All" to change
			selectAllChkbox.addEventListener('change', (event) => {
				if (event.target.checked) {
					divCheckboxes.forEach((divCheckbox) => {
						if(!divCheckbox.checked) {
							divCheckbox.click();
						}
					});
				} else {
					if (chkboxCount == divFrames.length) {
						divCheckboxes.forEach((divCheckbox) => {
							divCheckbox.click();
						});
					}
				}
			});
		</script>
	</main>
<?php
	require "footer.php"; // Use common footer file so no need to repeat for each page
?>