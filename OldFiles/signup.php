<?php
/**
 * Signup Page
 *
 * PHP script for the signup page. Initiates a new session, unsets the 'page'
 * session variable if it is set, and includes a common header file. Provides
 * user-friendly error messages for various scenarios, such as empty fields,
 * invalid email or username, password mismatch, or already taken username or email.
 * Displays a form for users to sign up with a username, email, and password.
 * If signup is successful, a success message is shown.
 * Provides a link to the password reset page.
 *
 * Note: This page also handles password reset success and error messages.
 * If the password reset is successful, it displays a success message.
 * If there is an error during the password reset process, it shows an appropriate
 * error message, such as SQL error or an issue with the provided password.
 *
 */
	// Start a new session or resume the existing session
	session_start();
	
	// Set the 'page' variable in the Session
	$_SESSION['page'] = 'signup';

	// Include the common header file to avoid repetition
	require "header.php"; // Use common header file so no need to repeat for each page
?>


	<main>
		<div class="w3-center w3-wide" style="padding:10px">
			<h1>Signup</h1>

			<?php
				// Provide useful error information to the user
				if (isset($_SESSION['error'])) {
					if ($_SESSION['error'] == 'empty_fields') {
						echo '<p>Fill in all fields!</p>';
					} else if ($_SESSION['error'] == 'invalid_email_username') {
						echo '<p>Invalid username and e-mail!</p>';
					} else if ($_SESSION['error'] == 'exists') {
						echo '<p>Username or Email is already in use!</p>';
					} else if ($_SESSION['error'] == 'passwords_not_match'){
						echo '<p>Passwords do not match!</p>';
					}
				}
				else if (isset($_SESSION['success'])) {
					echo '<p>Signup successful!</p>';
				}
			?>

			<!-- Provide a form for signing up -->
			<form action="includes/signup.inc.php" method="post">
				<?php
					// Populate username if it is set from the validation file
					echo '<input style="margin:10px" type="text" name="username" ';
					if(isset($_SESSION['username'])){
						echo 'value='.$_SESSION['username'];
					} else {
						echo 'placeholder="Username"';
					}
					echo ' required></br>';

					// Populate the email if it is set in from the validation file
					echo '<input style="margin:10px" type="text" name="email" ';
					if(isset($_SESSION['email'])){
						echo 'value='.$_SESSION['email'];
					} else {
						echo 'placeholder="E-mail"'; 
					}
					echo ' required></br>';
				?>

				<input style="margin:10px" type="password" name="pass1" placeholder="Password" required></br>
				<input style="margin:10px" type="password" name="pass2" placeholder="Retype Password" required></br>
				<button style="margin:10px" type="Submit" name="signup-submit">Submit</button>
			</form>
			
			
			<?php
				// Provide the ability to reset passwords using this same page
				if (isset($_SESSION["reset"])) {
					echo '<p>Your password has been reset!</p>';
				}
			?>

			<!-- This is where someone can reset their password -->
			<a href="pwdreset.php">Forgot your password?</a>
		</div>
	</main>
	
<?php
	// Include the common footer file to avoid repetition
	require "footer.php";
?>