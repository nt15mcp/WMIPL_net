<?php
/**
 * Roster Page
 *
 * PHP script for the roster page. Initiates a new session, sets the 'page'
 * session variable to 'roster', and includes a common header file. Displays
 * a roster table with sortable columns (Last Name, First Name, Number, Team, Division).
 */
	// Start a new session or resume the existing session
	session_start();

	// Set the 'page' session variable to 'roster'
	$_SESSION['page']="roster";
	
	// Include the common header file to maintain consistency across pages
	require "header.php"; // Use common header file so no need to repeat for each page
?>

	<main>
		<!-- Roster Page Header -->
		<div class="w3-center roster-container">
			<h1>ROSTER</h1>
		</div>

		<!-- Roster Table -->
		<div class="w3-wide w3-center scores-container roster">
			<table class="w3-table" id="roster-table">
				<!-- Table Header -->
				<thead>
					<tr class="headrow">
						<!-- Sortable Columns -->
						<th id="last-name-button" class="sort-by" onclick="sortby(0)"><h2>Last Name</h2></th>
						<th id="first-name-button" class="sort-by" onclick="sortby(1)"><h2>First Name</h2></th>
						<th id="number-button" class="sort-by" onclick="sortby(2)"><h2>Number</h2></th>
						<th id="team-button" class="sort-by" onclick="sortby(3)"><h2>Team</h2></th>
						<th id="div-button" class="sort-by" onclick="sortby(4)"><h2>Div</h2></th>
					</tr>
				</thead>

				<!-- Table Body -->
				<tbody>
					<?php
						// Include scores from an external file
						require "includes/scores.inc.php";
						$roster_by_last_name = array();

						// Iterate through the roster data and organize by last name
						foreach($roster as $div=>$teams){
							foreach($teams as $team=>$numbers){
								foreach($numbers as $number=>$shooters){
									if($shooters != 'DUMMY'){
										$names = explode(' ',$shooters);

										// Handle multiple-word last names
										if(count($names)>2){
											for($x=2;$x<count($names);$x++){
												$names[0] .= ' '.$names[$x];
											}
										}

										// Store organized roster data
										array_push($roster_by_last_name,array($names[0], $names[1], $number, $team, $div));
									}
								}
							}
						}

						// Sort the roster data by last name
						array_multisort($roster_by_last_name);

						// Display roster rows in the table body
						for($x=0;$x<count($roster_by_last_name);$x++){
							echo'
								<tr class="roster-row">
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

			// Set the sorting direction to ascending:
			dir = "asc";
			
			// Make a loop that will continue until no switching has been done:
			while(switching) {
				// Start by saying no switching has been done:
				switching = false;

				rows = table.rows;
				
				// Loop through all table rows (except the first which is the headers):
				for(i=1;i<(rows.length - 1);i++){
					//start by saying there should be no switching
					shouldSwitch = false;

					// Get two elements to compare from the current row to the next:
                	x = rows[i].getElementsByTagName("td")[n];
					y = rows[i+1].getElementsByTagName("td")[n];
					
					// Check if the two rows should switch place, based on the direction:
					if (dir == "asc") {
						if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
							// If so, mark as a switch and break the loop:
							shouldSwitch = true;
							break;
						}
					} else if (dir == "desc") {
						if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
							// If so, mark as a switch and break the loop:
							shouldSwitch = true;
							break;
						}
					}
				}

				if (shouldSwitch) {
					// If a switch as been marked, make the switch and mark that a switch has been done:
					rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
					switching = true;

					// Each time a switch is done, increase this count by 1:
					switchcount ++;
				} else {
					// If no switching has been done AND the direction is "asc",
					// set the direction to "desc" and run the loop again
					if (switchcount == 0 && dir == "asc") {
						dir = "desc";
						switching = true;
					}
				}
			}
		}
	</script>
<?php
	// Include the common footer file to maintain consistency across pages
	require "footer.php";
?>