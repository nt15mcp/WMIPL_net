<?php
	// Need to start a new session if necessary and track what page we are on for this session 
	session_start();
	$_SESSION['page']="scores";
	require "header.php"; // Use common header file so no need to repeat for each page
?>

	<main>
		<?php require 'includes/scores.inc.php' ?>
		<div>
			<!-- Setup a selection box bar across the top of the page to select divisions for viewing -->
			<div class="w3-bar w3-center w3-border w3-blue">
				<label class="w3-text-black w3-bar-item">Select to View In Page</label>
				<?php 
					foreach ($divisions as $div=>$teams){
						if ($div == 'U'){
							echo '
								<div class="w3-bar-item">
									<input id="unassChk" type="checkbox" label="Unassigned" value="false"><label>Unassigned</label>
								</div>
							';
						} else {
							echo '
								<div class="w3-bar-item">
									<input id="div'.$div.'Chk" type="checkbox" label="Division '.$div.'" value="false"><label>Division '.$div.'</label>
								</div>
							';
						} 
					}
					echo '
						<div class="w3-bar-item">
							<input id="selectAllChk" type="checkbox" label="Select/Deselect All" value="true"><label>Select/Deselect All</label>
						</div>
					';
				?>			
			</div>
		</div>
		<!-- create each division's display container -->
		<?php
			foreach($divisions as $div=> $teams){
				echo '
					<div class="w3-wide w3-center" id="Div'.$div.'" style="display:none;padding:10px">
					<table>
						<thead>
							<tr>
								<th colspan="3"><h1>Division '.$div.'</h1></th>						
							</tr>
						</thead>
					</table>
					<br>
				';
				require 'scores-team.php';
				echo '
					</div>
				';
			}
		?>	
		<!-- Dynamically update the displayed divs based on the status of the checkboxes -->
		<script type="text/javascript">
			// Create a constant for each checkbox
			<?php 
				$divCheckboxes = '';
				$divFrames = '';
				foreach($divisions as $div=>$teams){
					if($div == 'U'){
						echo '
							const unassChkbox = document.getElementById("unassChk");
						';
						$divCheckboxes += ', unassChkbox';
						$divFrames += ', unass';
					} else {
						echo '
							const div'.$div.'Chkbox = document.getElementById("div'.$div.'Chk");
						';
						if($divCheckboxes == ''){
							$divCheckboxes = 'div'.$div.'Chkbox';
							$divFrames = 'div'.$div;
						} else {
							$divCheckboxes .= ', div'.$div.'Chkbox';
							$divFrames .= ', div'.$div;
						}
					}
				}
			?>
			const selectAllChkbox = document.getElementById("selectAllChk");
			
			// Create an array of the checkboxes
			const divCheckboxes = [<?php echo $divCheckboxes ?>];

			// Create a constant for each Div
			<?php
				foreach($divisions as $div => $teams){
					if($div == 'U'){
						echo 'const unass = document.getElementById("Unass");';
					}
					echo 'const div'.$div.' = document.getElementById("Div'.$div.'");';
				}
			?>
			// Create an array of the iframes
			const divFrames = [<?php echo $divFrames ?>];
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