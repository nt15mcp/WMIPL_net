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
		<div class="w3-wide w3-center scores-container">
			<table class="w3-table">
				<thead>
					<tr class="headrow">
						<th><h2>Last Name</h2></th>
						<th><h2>First Name</h2></th>
						<th><h2>Number</h2></th>
						<th><h2>Team</h2></th>
						<th><h2>Div</h2></th>
					</tr>
				</thead>
				<tbody>
					<?php
						require "includes/scores.inc.php"; // Get text area from database for display
						$roster_by_name = array();
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
										array_push($roster_by_name,array($names[0], $names[1], $number, $team, $div));
									}
								}
							}
						}
						array_multisort($roster_by_name);
						for($x=0;$x<count($roster_by_name);$x++){
							echo'
											<tr class="individual-row">
												<td>'.$roster_by_name[$x][0].'</td>
												<td>'.$roster_by_name[$x][1].'</td>
												<td>'.$roster_by_name[$x][2].'</td>
												<td>'.$roster_by_name[$x][3].'</td>
												<td>'.$roster_by_name[$x][4].'</td>
											</tr>
										';
						}
					?>
				</tbody>
			</table>
		</div>
	</main>
<?php
	require "footer.php"; // Use common footer file so no need to repeat for each page
?>