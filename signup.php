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
	
	// Unset the 'page' session variable if it is set
	if (isset($_SESSION['page'])){
		unset($_SESSION['page']);
	}

	// Include the common header file to avoid repetition
	require "header.php"; // Use common header file so no need to repeat for each page
?>


	<main>
		<div class="w3-center w3-wide" style="padding:10px">
			<h1>Signup</h1>

			<?php
				// Provide useful error information to the user
				if (isset($_GET['error'])) {
					if ($_GET['error'] == 'emptyfields') {
						echo '<p>Fill in all fields!</p>';
					}
					else if ($_GET['error'] == 'invalidemailusername') {
						echo '<p>Invalid username and e-mail!</p>';
					}
					else if ($_GET['error'] == 'invalidemail') {
						echo '<p>Invalid e-mail!</p>';
					}
					else if ($_GET['error'] == 'invalidusername') {
						echo '<p>Invalid username!</p>';
					}
					else if ($_GET['error'] == 'passwordcheck') {
						echo '<p>Your passwords do not match!</p>';
					}
					else if ($_GET['error'] == 'taken') {
						echo '<p>Username or Email is already in use!</p>';
					}
				}
				else if (isset($_GET['signup'])) {
					if ($_GET['signup'] == 'success') {
						echo '<p>Signup successful!</p>';
					}
				}
			?>

			<!-- Provide a form for signing up -->
			<form action="includes/signup.inc.php" method="post">
				<?php
					// Populate the username input if it is set in the URL parameters
					if (isset($_GET['username'])) {
						echo '<input style="margin:10px" type="text" name="username" value="'.$_GET['username'].'" required></br>';			
					}
					else {
						echo '<input style="margin:10px" type="text" name="username" placeholder="Username" required></br>';
					}

					// Populate the email input if it is set in the URL parameters
					if (isset($_GET['email'])) {
						echo '<input style="margin:10px" type="text" name="email" value="'.$_GET['email'].'" required></br>';			
					}
					else {
						echo '<input style="margin:10px" type="text" name="email" placeholder="E-mail" required></br>';
					}
				?>

				<input style="margin:10px" type="password" name="pass1" placeholder="Password" required></br>
				<input style="margin:10px" type="password" name="pass2" placeholder="Retype Password" required></br>
				<button style="margin:10px" type="Submit" name="signup-submit">Submit</button>
			</form>
			
			
			<?php
				// Provide the ability to reset passwords using this same page
				if (isset($_GET["reset"])) {
					if ($_GET["reset"] == "success") {
						echo '<p>Your password has been reset!</p>';
					}
				}
				else if(isset($_GET["error"])) {
					If ($_GET["error"] == "sqlierror") {
						echo '<p>There was a problem processing your request.</br><p>Please try again later</p>';
					}
					else if ($_GET["error"] == "invalidpassword") {
						echo '<p>There was a problem with your password.</br><p>Please try again with the link provided in your email</p>';
					}
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