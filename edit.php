<?php
	session_start();
	if(!isset($_SESSION['firstname'])){
		header('Location index.php');
	}
	unset($_SESSION['page']);
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
				<select name="state">
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="AL"){echo 'selected';}} ?> value="AL">Alabama (AL)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="AK"){echo 'selected';}} ?> value="AK">Alaska (AK)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="AZ"){echo 'selected';}} ?> value="AZ">Arizona (AZ)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="AR"){echo 'selected';}} ?> value="AR">Arkansas (AR)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="CA"){echo 'selected';}} ?> value="CA">California (CA)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="CO"){echo 'selected';}} ?> value="CO">Colorado (CO)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="CT"){echo 'selected';}} ?> value="CT">Connecticut (CT)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="DE"){echo 'selected';}} ?> value="DE">Delaware (DE)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="DC"){echo 'selected';}} ?> value="DC">District Of Columbia (DC)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="FL"){echo 'selected';}} ?> value="FL">Florida (FL)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="GA"){echo 'selected';}} ?> value="GA">Georgia (GA)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="HI"){echo 'selected';}} ?> value="HI">Hawaii (HI)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="ID"){echo 'selected';}} ?> value="ID">Idaho (ID)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="IL"){echo 'selected';}} ?> value="IL">Illinois (IL)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="IN"){echo 'selected';}} ?> value="IN">Indiana (IN)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="IA"){echo 'selected';}} ?> value="IA">Iowa (IA)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="KS"){echo 'selected';}} ?> value="KS">Kansas (KS)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="KY"){echo 'selected';}} ?> value="KY">Kentucky (KY)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="LA"){echo 'selected';}} ?> value="LA">Louisiana (LA)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="ME"){echo 'selected';}} ?> value="ME">Maine (ME)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="MD"){echo 'selected';}} ?> value="MD">Maryland (MD)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="MA"){echo 'selected';}}else{echo 'selected';} ?> value="MA">Massachusetts (MA)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="MI"){echo 'selected';}} ?> value="MI">Michigan (MI)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="MN"){echo 'selected';}} ?> value="MN">Minnesota (MN)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="MS"){echo 'selected';}} ?> value="MS">Mississippi (MS)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="MO"){echo 'selected';}} ?> value="MO">Missouri (MO)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="MT"){echo 'selected';}} ?> value="MT">Montana (MT)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="NE"){echo 'selected';}} ?> value="NE">Nebraska (NE)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="NV"){echo 'selected';}} ?> value="NV">Nevada (NV)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="NH"){echo 'selected';}} ?> value="NH">New Hampshire (NH)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="NJ"){echo 'selected';}} ?> value="NJ">New Jersey (NJ)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="NM"){echo 'selected';}} ?> value="NM">New Mexico (NM)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="NY"){echo 'selected';}} ?> value="NY">New York (NY)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="NC"){echo 'selected';}} ?> value="NC">North Carolina (NC)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="ND"){echo 'selected';}} ?> value="ND">North Dakota (ND)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="OH"){echo 'selected';}} ?> value="OH">Ohio (OH)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="OK"){echo 'selected';}} ?> value="OK">Oklahoma (OK)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="OR"){echo 'selected';}} ?> value="OR">Oregon (OR)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="PA"){echo 'selected';}} ?> value="PA">Pennsylvania (PA)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="RI"){echo 'selected';}} ?> value="RI">Rhode Island (RI)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="SC"){echo 'selected';}} ?> value="SC">South Carolina (SC)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="SD"){echo 'selected';}} ?> value="SD">South Dakota (SD)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="TN"){echo 'selected';}} ?> value="TN">Tennessee (TN)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="TX"){echo 'selected';}} ?> value="TX">Texas (TX)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="UT"){echo 'selected';}} ?> value="UT">Utah (UT)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="VT"){echo 'selected';}} ?> value="VT">Vermont (VT)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="VA"){echo 'selected';}} ?> value="VA">Virginia (VA)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="WA"){echo 'selected';}} ?> value="WA">Washington (WA)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="WV"){echo 'selected';}} ?> value="WV">West Virginia (WV)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="WI"){echo 'selected';}} ?> value="WI">Wisconsin (WI)</option>
					<option <?php if(isset($_SESSION['state'])){if($_SESSION['state']==="WY"){echo 'selected';}} ?> value="WY">Wyoming (WY)</option>
				</select>
				<label for="zip">Zip:</label>
               	<input type="number" id="zip" name="zip" <?php echo "value='".$_SESSION['zip']."'";?>></br>
				<?php If(isset($_GET['error'])){if($_GET['error'] == "invalidzip"){echo '<strong style="text-color:red">ZIP is invalid! Must be 5 numbers only!</strong>';}} ?>
				</br>
			</div>
			</br>
			<div class="w3-input w3-left">
			</br>
				<label for="phonepri">Phone (primary):</label>
				<input type="tel" id="phonepri" name="phonepri" <?php echo "value=".$_SESSION['phonepri'];?>></br>
				<?php if(isset($_GET['error'])){if($_GET['error'] == "invalidpriphone"){echo '<strong style="text-color:red">Phone number is invalid!</strong>';}} ?>
				</br>
				<label for="phonesec">Phone (secondary):</label>
				<input type="tel" id="phonesec" name="phonesec" <?php echo "value=(".$_SESSION['phonesec'];?>></br>
				<?php if(isset($_GET['error'])){if($_GET['error'] == "invalidsecphone"){echo '<strong style="text-color:red">Phone number is invalid!</strong>';}} ?>
				</br>
			</div>
			</br>
				<button type="submit" name="edit-submit">Submit Changes</button>
			</form>
			</br>
		</div>
	</main>
	<script type="text/javascript">
		const $priphone = document.getElementByID('phonepri');
		const $secphone = document.getElementByID('phonesec');
		const $zip = document.getElementByID('zip');
		$priphone.inputmask({"mask": "(999) 999-9999"});
		$secphone.inputmask({"mask": "(999) 999-9999"});
		$zip.inputmask({"mask": "99999"});
	</script>
		
<?php
	require "footer.php";
?>