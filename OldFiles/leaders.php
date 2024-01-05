<?php
/**
 * Leaders Page
 *
 * PHP script for the leaders page of the website. Starts a session, sets the current
 * page in the session data, includes a common header file, retrieves scores information
 * from the database, and displays leaderboards for individual winners and team winners.
 */

	// Start a new session or resume the existing session
	session_start();

	// Set the current page to "leaders" in the session data
	$_SESSION['page']="leaders";

	// Include the common header file to maintain consistency across pages
	require "header.php";

	// Include the scores information retrieval script
	require "includes/scores.inc.php";
?>

	<main>
		<div class="w3-center leader-container" style="padding:10px">
			<h1>Leader Board</h1>
		</div>
		<!-- Displays the Individual leaderboard -->
		<div class="w3-wide w3-center" style="padding:10px">
			<button class="w3-bar-item active-tab" id="individual_button" onclick="displayTab('individuals')"><h2>INDIVIDUAL WINNERS</h2></button>
			<button class="w3-bar-item inactive-tab" id="team_button" onclick="displayTab('team')"><h2>TEAM WINNERS</h2></button>
		</div>
		<div class="scores-container active-content" id="individuals">
			<table class="w3-table winners">
				<thead>
					<tr>
						<th><h3>CLASS</h3></th>
						<th colspan="2"><h3>HIGH AVERAGE</h3></th>
						<th colspan="2"><h3>HIGH SINGLE</h3></th>
						<th colspan="2"><h3>MOST IMPROVED</h3></th>
					</tr>
				</thead>
				<tbody>
				<?php
					foreach($individual_winners as $class=>$values){
						echo '
							<tr class="winner-row">
								<td>'.$class.'</td>
								<td>'.$individual_winners_name[$class]['avg'].'</td>
								<td>'.number_format($values['avg'],1).'</td>
								<td>'.$individual_winners_name[$class]['high'].'</td>
								<td>'.$values['high'].'</td>
								<td>'.$individual_winners_name[$class]['most_improv'].'</td>
								<td>'.number_format($values['most_improv'],1).'</td>
							</tr>
						';
					}
				?>
				</tbody>
				<thead>
					<tr>
						<th colspan="7"><h3>RUNNERS UP</h3></th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($individual_runner as $class=>$values){
							echo '
								<tr class="winner-row">
									<td>'.$class.'</td>
									<td>'.$individual_runner_name[$class]['avg'].'</td>
									<td>'.number_format($values['avg'],1).'</td>
									<td>'.$individual_runner_name[$class]['high'].'</td>
									<td>'.$values['high'].'</td>
									<td>'.$individual_runner_name[$class]['most_improv'].'</td>
									<td>'.number_format($values['most_improv'],1).'</td>
								</tr>
							';
						}
					?>
				</tbody>
				<thead>
					<tr>
						<th colspan="7"><h3>CLOSING IN</h3></th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($individual_close as $class=>$values){
							echo '
								<tr class="winner-row">
									<td>'.$class.'</td>
									<td>'.$individual_close_name[$class]['avg'].'</td>
									<td>'.number_format($values['avg'],1).'</td>
									<td>'.$individual_close_name[$class]['high'].'</td>
									<td>'.$values['high'].'</td>
									<td>'.$individual_close_name[$class]['most_improv'].'</td>
									<td>'.number_format($values['most_improv'],1).'</td>
								</tr>
							';
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="scores-container tab-content" id="team">
			<table class="w3-table">
				<thead>
					<tr>
						<?php
							foreach($team_winners as $div => $name){
								echo '<th><h3>DIVISION '.$div.'</h3></th>';
							}
						?>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php
							foreach($team_winners as $div => $name){
								echo '<td><h4>'.$name.'</h4></td>';
							}
						?>
					</tr>
					<?php
						$divs = array_keys($team_winners_names);
						for($n=0;$n<count($team_winners_names[$divs[0]]);$n++){
							echo '<tr class="winner-row">';
							for($m=0;$m<count($divs);$m++){
								echo '<td>'.$team_winners_names[$divs[$m]][$n].'</td>';
							}
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</main>

	<!-- JavaScript to switch between individual and team tabs -->
	<script type="text/javascript">
		function displayTab(tabId){
			let indBut = document.getElementById("individual_button");
			let teamBut = document.getElementById("team_button");
			let indTab = document.getElementById("individuals");
			let teamTab = document.getElementById("team");
			
			if(tabId == "individuals"){
				if(teamBut.classList.contains("active-tab")){
					indBut.classList.replace("inactive-tab","active-tab");
					teamBut.classList.replace("active-tab","inactive-tab");
					indTab.classList.replace("tab-content","active-content");
					teamTab.classList.replace("active-content","tab-content");
				}
			}else{
				if(indBut.classList.contains("active-tab")){
					teamBut.classList.replace("inactive-tab","active-tab");
					indBut.classList.replace("active-tab","inactive-tab");
					teamTab.classList.replace("tab-content","active-content");
					indTab.classList.replace("active-content","tab-content");
				}
			}
		}
	</script>

<?php
	// Include the common footer file to maintain consistency across pages
	require "footer.php";
?>