<?php
/**
 * Edit Account Information Page
 * 
 * PHP script for the account information editing page. Handles session initiation,
 * redirects users to the index page if not logged in, and includes a common header.
 * Displays a form for users to edit their personal information.
 */
	// Need to start a new session if necessary and track what page we are on for this session 
	session_start();

	// Redirect to index.php if the user is not logged in
	if(!isset($_SESSION['firstname'])){
		header('Location index.php');
		exit();
	}
	$_SESSION['page']='edit';

	// Include the common header file to maintain consistency across pages
	require "header.php";
	
?>

	<main>
		<div class="w3-center" style="padding:10px">
		</br>
			<h1>Your account information</h1>
			<p style="text-align:left">Your name will be visible to members when signed into the website.  The rest of the information contained in this form will only be used by you or to contact you</p>
			<form action="includes/edit-submit.inc.php" class="w3-form" method="post">
			<div class="w3-input w3-left">
				<label for="userName">Username:</label>
				<input type="text" name="userName" <?php echo "value='".$_SESSION['userName']."'";?>>
				<label for="email">Email Address:</label>
				<input type="text" name="email" <?php echo "value='".$_SESSION['email']."'";?>>
				</br>
			</div>
			</br>
			<div class="w3-input w3-left">
			</br>
				<label for="firstname">First Name:</label>
				<input type="text" name="firstname" <?php echo "value='".$_SESSION['firstname']."'";?>>
				<label for="middlename">Middle Name:</label>
				<input type="text" name="middlename"<?php echo "value='".$_SESSION['middlename']."'";?>>
				<label for="lastname">Last Name:</label>
				<input type="text" name="lastname" <?php echo "value='".$_SESSION['lastname']."'";?>>
				</br>
			</div>
			</br>
			<div class="w3-input w3-left">
			</br>
				<label for="street">Street Address:</label>
				<input type="text" name="street" <?php echo "value='".$_SESSION['street']."'";?>></br>
				</br>
				<label for="street2">Street Address:</label>
				<input type="text" name="street2" <?php echo "value='".$_SESSION['street2']."'";?>></br>
				</br>
				<label for="city">City:</label>
              	<input type="text" name="city" <?php echo "value='".$_SESSION['city']."'";?>>
				<label for="state">State:</label>
				<?php
					$states = [
						'AL' => 'Alabama (AL)',
						'AK' => 'Alaska (AK)',
						'AZ' => 'Arizona (AZ)',
						'AR' => 'Arkansas (AR)',
						'CA' => 'California (CA)',
						'CO' => 'Colorado (CO)',
						'CT' => 'Connecticut (CT)',
						'DE' => 'Delaware (DE)',
						'FL' => 'Florida (FL)',
						'GA' => 'Georgia (GA)',
						'HI' => 'Hawaii (HI)',
						'ID' => 'Idaho (ID)',
						'IL' => 'Illinois (IL)',
						'IN' => 'Indiana (IN)',
						'IA' => 'Iowa (IA)',
						'KS' => 'Kansas (KS)',
						'KY' => 'Kentucky (KY)',
						'LA' => 'Louisiana (LA)',
						'ME' => 'Maine (ME)',
						'MD' => 'Maryland (MD)',
						'MA' => 'Massachusetts (MA)',
						'MI' => 'Michigan (MI)',
						'MN' => 'Minnesota (MN)',
						'MS' => 'Mississippi (MS)',
						'MO' => 'Missouri (MO)',
						'MT' => 'Montana (MT)',
						'NE' => 'Nebraska (NE)',
						'NV' => 'Nevada (NV)',
						'NH' => 'New Hampshire (NH)',
						'NJ' => 'New Jersey (NJ)',
						'NM' => 'New Mexico (NM)',
						'NY' => 'New York (NY)',
						'NC' => 'North Carolina (NC)',
						'ND' => 'North Dakota (ND)',
						'OH' => 'Ohio (OH)',
						'OK' => 'Oklahoma (OK)',
						'OR' => 'Oregon (OR)',
						'PA' => 'Pennsylvania (PA)',
						'RI' => 'Rhode Island (RI)',
						'SC' => 'South Carolina (SC)',
						'SD' => 'South Dakota (SD)',
						'TN' => 'Tennessee (TN)',
						'TX' => 'Texas (TX)',
						'UT' => 'Utah (UT)',
						'VT' => 'Vermont (VT)',
						'VA' => 'Virginia (VA)',
						'WA' => 'Washington (WA)',
						'WV' => 'West Virginia (WV)',
						'WI' => 'Wisconsin (WI)',
						'WY' => 'Wyoming (WY)'
					];
				?>
				<select name="state">
				<?php
					foreach ($states as $code => $name) {
						$selected = isset($_SESSION['state']) && $_SESSION['state'] === $code ? 'selected' : '';
						echo "<option $selected value=\"$code\">$name</option>";
					}
				?>
				</select>
				<label for="zip">Zip:</label>
               	<input type="number" id="zip" name="zip" <?php echo "value='".$_SESSION['zip']."'";?>>
				</br>
				<?php If(isset($_GET['error'])){if($_GET['error'] == "invalidzip"){echo '<strong style="text-color:red">ZIP is invalid! Must be 5 numbers only!</strong>';}} ?>
				</br>
			</div>
			</br>
			<div class="w3-input w3-left">
			</br>
				<label for="phone">Phone:</label>
				<input type="tel" id="phone" name="phone" 
				<?php echo "value=".$_SESSION['phone'];?>>
				</br>
				<?php if(isset($_GET['error'])){if($_GET['error'] == "invalidphone"){echo '<strong style="text-color:red">Phone number is invalid!</strong>';}} ?>
				</br>
			</div>
			</br>
				<button type="submit" name="edit-submit">Submit Changes</button>
			</form>
			</br>
		</div>
	</main>
	<!-- Use Javascript to mask the phone inputs so the value is consistent -->
	<script type="text/javascript">
		const $priphone = document.getElementByID('phone');
		const $zip = document.getElementByID('zip');
		$phone.inputmask({"mask": "(999) 999-9999"});
		$zip.inputmask({"mask": "99999"});
	</script>
		
<?php
	require "footer.php"; // Use common footer file so no need to repeat for each page
?>