<?php
	// Need to start a new session if necessary and track what page we are on for this session 
	session_start();
	$_SESSION['page']="roster";
	require "header.php"; // Use common header file so no need to repeat for each page
?>

	<main>
		<div class="w3-center">
			<h1>ROSTER</h1>
		</div>
		<div class="w3-wide w3-center scores-container roster">
			<table class="w3-table" id="roster-table">
				<thead>
					<tr class="headrow">
						<th id="last-name-button" class="sort-by" onclick="sortby(0)"><h2>Last Name</h2></th>
						<th id="first-name-button" class="sort-by" onclick="sortby(1)"><h2>First Name</h2></th>
						<th id="number-button" class="sort-by" onclick="sortby(2)"><h2>Number</h2></th>
						<th id="team-button" class="sort-by" onclick="sortby(3)"><h2>Team</h2></th>
						<th id="div-button" class="sort-by" onclick="sortby(4)"><h2>Div</h2></th>
					</tr>
				</thead>
				<tbody>
					<?php
						require "includes/scores.inc.php"; // Get text area from database for display
						$roster_by_last_name = array();
						foreach($roster as $div=>$teams){
							foreach($teams as $team=>$numbers){
								foreach($numbers as $number=>$shooters){
									if($shooters != 'DUMMY'){
										$names = explode(' ',$shooters);
										if(count($names)>2){
											for($x=2;$x<count($names);$x++){
												$names[0] .= ' '.$names[$x];
											}
										}
										array_push($roster_by_last_name,array($names[0], $names[1], $number, $team, $div));
									}
								}
							}
						}
						array_multisort($roster_by_last_name);
						for($x=0;$x<count($roster_by_last_name);$x++){
							echo'
											<tr class="individual-row">
												<td>'.$roster_by_last_name[$x][0].'</td>
												<td>'.$roster_by_last_name[$x][1].'</td>
												<td>'.$roster_by_last_name[$x][2].'</td>
												<td>'.$roster_by_last_name[$x][3].'</td>
												<td>'.$roster_by_last_name[$x][4].'</td>
											</tr>
										';
						}
					?>
				</tbody>
			</table>
		</div>
	</main>
	<script type="text/javascript">
		function sortby(n){
			var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
			table = document.getElementById("roster-table");
			switching = true;
			// set the sorting direction to ascending:
			dir = "asc";
			/* make a loop that will continue until no switching has been done: */
			while(switching) {
				// start by saying no switching has been done:
				switching = false;
				rows = table.rows;
				// loop through all table rows (except the first which is the headers)
				for(i=1;i<(rows.length - 1);i++){
					//start by saying there should be no switching
					shouldSwitch = false;
					// get two elements to compare from current row to the next
					x = rows[i].getElementsByTagName("td")[n];
					y = rows[i+1].getElementsByTagName("td")[n];
					// check if the two rows should switch place, based on the direction
					if (dir == "asc") {
						if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
							//if so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
						}
					} else if (dir == "desc") {
						if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
							//if so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
						}
					}
				}
				if (shouldSwitch) {
					// if a switch as been marked, make the switch and mark that a switch has been done:
					rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
					switching = true;
					// each time a switch is done, increase this count by 1:
					switchcount ++;
				} else {
					// if no switching has been done AND the direction is "asc", set the direction to "desc" and run the loop again
					if (switchcount == 0 && dir == "asc") {
						dir = "desc";
						switching = true;
					}
				}
			}
		}
	</script>
<?php
	require "footer.php"; // Use common footer file so no need to repeat for each page
?>