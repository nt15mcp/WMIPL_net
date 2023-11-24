<?php
	session_start();
	$_SESSION['page']="scores";
	require "header.php";
?>

	<main>
		<div>
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
		<script type="text/javascript">
				const divAChkbox = document.getElementById('divAChk');
				const divBChkbox = document.getElementById('divBChk');
				const divCChkbox = document.getElementById('divCChk');
				const divDChkbox = document.getElementById('divDChk');
				const divEChkbox = document.getElementById('divEChk');
				const divFChkbox = document.getElementById('divFChk');
				const divGChkbox = document.getElementById('divGChk');
				const unassChkbox = document.getElementById('unassChk');
				const selectAllChkbox = document.getElementById('selectAllChk');
				const divA = document.getElementById('DivA');
				const divB = document.getElementById('DivB');
				const divC = document.getElementById('DivC');
				const divD = document.getElementById('DivD');
				const divE = document.getElementById('DivE')
				const divF = document.getElementById('DivF');
				const divG = document.getElementById('DivG');
				const unass = document.getElementById('Unass');
				var chkboxarr = new Array();

					divAChkbox.addEventListener('change', (event) => {
					  if (event.target.checked) {
						divA.style.display = 'block';
						chkboxarr.push("A");
						if (chkboxarr.length == 8) {
							selectAllChkbox.checked = true;
						}
					  } else {
						divA.style.display = 'none';
						for( var i= 0; i < chkboxarr.length; i++){
							if ( chkboxarr[i] === "A") {
								chkboxarr.splice(i, 1);
							}
						}
						if (chkboxarr.length < 8) {
							selectAllChkbox.checked = false;
						}
					  }
					})
					divBChkbox.addEventListener('change', (event) => {
					  if (event.target.checked) {
						divB.style.display = 'block';
						chkboxarr.push("B");
						if (chkboxarr.length == 8) {
							selectAllChkbox.checked = true;
						}
					  } else {
						divB.style.display = 'none';
						for( var i= 0; i < chkboxarr.length; i++){
							if ( chkboxarr[i] === "B") {
								chkboxarr.splice(i, 1);
							}
						}
						if (chkboxarr.length < 8) {
							selectAllChkbox.checked = false;
						}
					  }
					})
					divCChkbox.addEventListener('change', (event) => {
					  if (event.target.checked) {
						divC.style.display = 'block';
						chkboxarr.push("C");
						if (chkboxarr.length == 8) {
							selectAllChkbox.checked = true;
						}
					  } else {
						divC.style.display = 'none';
						for( var i= 0; i < chkboxarr.length; i++){
							if ( chkboxarr[i] === "C") {
								chkboxarr.splice(i, 1);
							}
						}
						if (chkboxarr.length < 8) {
							selectAllChkbox.checked = false;
						}
					  }
					})
					divDChkbox.addEventListener('change', (event) => {
					  if (event.target.checked) {
						divD.style.display = 'block';
						chkboxarr.push("D");
						if (chkboxarr.length == 8) {
							selectAllChkbox.checked = true;
						}
					  } else {
						divD.style.display = 'none';
						for( var i= 0; i < chkboxarr.length; i++){
							if ( chkboxarr[i] === "D") {
								chkboxarr.splice(i, 1);
							}
						}
						if (chkboxarr.length < 8) {
							selectAllChkbox.checked = false;
						}
					  }
					})
					divEChkbox.addEventListener('change', (event) => {
					  if (event.target.checked) {
						divE.style.display = 'block';
						chkboxarr.push("E");
						if (chkboxarr.length == 8) {
							selectAllChkbox.checked = true;
						}
					  } else {
						divE.style.display = 'none';
						for( var i= 0; i < chkboxarr.length; i++){
							if ( chkboxarr[i] === "E") {
								chkboxarr.splice(i, 1);
							}
						}
						if (chkboxarr.length < 8) {
							selectAllChkbox.checked = false;
						}
					  }
					})
					divFChkbox.addEventListener('change', (event) => {
					  if (event.target.checked) {
						divF.style.display = 'block';
						chkboxarr.push("F");
						if (chkboxarr.length == 8) {
							selectAllChkbox.checked = true;
						}
					  } else {
						divF.style.display = 'none';
						for( var i= 0; i < chkboxarr.length; i++){
							if ( chkboxarr[i] === "F") {
								chkboxarr.splice(i, 1);
							}
						}
						if (chkboxarr.length < 8) {
							selectAllChkbox.checked = false;
						}
					  }
					})
					divGChkbox.addEventListener('change', (event) => {
					  if (event.target.checked) {
						divG.style.display = 'block';
						chkboxarr.push("G");
						if (chkboxarr.length == 8) {
							selectAllChkbox.checked = true;
						}
					  } else {
						divG.style.display = 'none';
						for( var i= 0; i < chkboxarr.length; i++){
							if ( chkboxarr[i] === "G") {
								chkboxarr.splice(i, 1);
							}
						}
						if (chkboxarr.length < 8) {
							selectAllChkbox.checked = false;
						}
					  }
					})
					unassChkbox.addEventListener('change', (event) => {
					  if (event.target.checked) {
						unass.style.display = 'block';
						chkboxarr.push("U");
						if (chkboxarr.length == 8) {
							selectAllChkbox.checked = true;
						}
					  } else {
						unass.style.display = 'none';
						for( var i= 0; i < chkboxarr.length; i++){
							if ( chkboxarr[i] === "U") {
								chkboxarr.splice(i, 1);
							}
						}
						if (chkboxarr.length < 8) {
							selectAllChkbox.checked = false;
						}
					  }
					})
					selectAllChkbox.addEventListener('change', (event) => {
						if (event.target.checked) {
							if(!divAChkbox.checked) {
								divAChkbox.click();
							}
							if(!divBChkbox.checked) {
								divBChkbox.click();
							}
							if(!divCChkbox.checked) {
								divCChkbox.click();
							}
							if(!divDChkbox.checked) {
								divDChkbox.click();
							}
							if(!divEChkbox.checked) {
								divEChkbox.click();
							}
							if(!divFChkbox.checked) {
								divFChkbox.click();
							}
							if(!divGChkbox.checked) {
								divGChkbox.click();
							}
							if(!unassChkbox.checked) {
								unassChkbox.click();
							}
						} else {
							if (chkboxarr.length == 8) {
								divAChkbox.click();
								divBChkbox.click();
								divCChkbox.click();
								divDChkbox.click();
								divEChkbox.click();
								divFChkbox.click();
								divGChkbox.click();
								unassChkbox.click();
							}
						}
					})
					</script>
	</main>
<?php
	require "footer.php";
?>