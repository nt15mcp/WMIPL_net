<?php
/**
 * Password Reset Page
 * 
 * PHP script for the password reset page. Handles session initiation,
 * includes common header and footer files, and displays a form for users
 * to reset their passwords based on the link provided in the email.
 */
	// Need to start a new session if necessary and track what page we are on for this session 
	session_start();
	// Check to see if the URL includes a selector value for resetting passwords
	if(!isset($_GET['selector']) && !isset($_SESSION['selector'])){
		// Shouldn't be here, send them home
		header("Location home.php");
		exit();
	}
	$_SESSION['page']='resetPwd';

	
	require "header.php"; // Use common header file so no need to repeat for each page
?>


	<main>
		<div class="w3-center w3-wide" style="padding:10px">
			<?php 
				if(isset($_GET['selector'])){
					// Find the two parts of the URL from the link provided by email
					$selector = filter_input(INPUT_GET,'selector',FILTER_SANITIZE_SPECIAL_CHARS);
					$validator = filter_input(INPUT_GET,'validator',FILTER_SANITIZE_SPECIAL_CHARS);
				} else {
					// Get the two parts of the original URL
					$selector = $_SESSON['selector'];
					$validator = $_SESSION['validator'];
				}
				
				// If we got here without all the data, throw an error
				if (empty($selector) || empty($validator)) {
					echo "We could not validate your request!";
				} else {
					// Make sure the data is the right kind of data
					if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ) {
						if(isset($_SESSION['error']) && $_SESSION['error'] == 'invalid_password'){
							echo '<p style="color:red;"><strong>Passwords are invalid!<strong></p>';
						}
			?>
						
						<!-- Create a form for changing our password -->
						<form action="includes/resetpwd.inc.php" method="post">
							<input type="hidden" name="selector" value="<?php echo $selector; ?>">
							<input type="hidden" name="validator" value="<?php echo $validator; ?>">
							<input type="password" name="password" placeholder="New Password">
							<input type="password" name="pass1" placeholder="Repeat Password">
							<button type="submit" name="new-password-submit" >Reset Password</button>
						</form>
						
			<?php
					}
				}
			?>
		</div>
	</main>
	
<?php
	require "footer.php"; // Use common footer file so no need to repeat for each page
?>