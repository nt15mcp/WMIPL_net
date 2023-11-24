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
				<div class="w3-bar-item">
					<input id="divGChk" type="checkbox" label="Division G" value="false"><label>Division G</label>
				</div>
				<div class="w3-bar-item">
					<input id="unassChk" type="checkbox" label="Unassigned" value="false"><label>Unassigned</label>
				</div>
				<div class="w3-bar-item">
					<input id="selectAllChk" type="checkbox" label="Select/Deselect All" value="true"><label>Select/Deselect All</label>
				</div>
				
			</div>
		</div>
		<!-- create iframes for each division viewing the associated Google Scheet -->
		<div class="w3-wide w3-center" id="DivA" style="display:none;padding:10px">
			<iframe title="Division A" width="100%" height="1250px" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQh-nhFYLIVrUbV6IYgkzQ1V0UCBdRXidYMLd3ZrnisdGG-ZpmjPN5HYkk4U6fUUGNvCPIaye9G_szb/pubhtml?widget=false&amp;amp;headers=false"></iframe>
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
			const divCheckboxes = [divAChkbox, divBChkbox, divCChkbox, divDChkbox, divEChkbox, divFChkbox, divGChkbox, unassChkbox];
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
			const divFrames = [divA, divB, divC, divD, divE, divF, divG, unass];
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
					} else {
						// Hide the iframe
						divFrames[index].style.display = 'none';
						// Decrement the count of visible frames
						chkboxCount = chkboxCount - 1;
					}
				});
			});
			//Determine if "Select All" should be checked
			if (chkboxCount == divFrames.length) {
				selectAllChkbox.checked = true;
			} else {
				if (selectAllChkbox.checked) {
					selectAllChkbox.checked = false;
				}
			}
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