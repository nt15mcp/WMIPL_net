<?php
/**
 * Password Reset Page
 *
 * PHP script for the password reset page. Initiates a new session, ensures the 'page'
 * session variable is unset, and includes a common header file. Displays a form for users
 * to input their email address to receive instructions on resetting their password.
 */

	// Start a new session or resume the existing session
	session_start();

	// Unset the 'page' session variable if it exists
	if (isset($_SESSION['page'])){
		unset($_SESSION['page']);
	}

	// Include the common header file to maintain consistency across pages
	require "header.php";
?>

	<main>
		<div class="w3-center w3-wide" style="padding:10px">
			<h1>Reset your password</h1>
			<p>An e-mail will be sent to you with instructions on how to reset your password.</p>

			<!-- Provide a form to input email address for password reset -->
			<form action="includes/pwdreset.inc.php" method="post">
				<input type="text" name="email" placeholder="Enter your e-mail address...">
				<button type="submit" name="reset-request-submit">Submit</button>
			</form>

			<?php 
				// Check for successful password reset request
				if (isset($_GET["reset"])) {
					if ($_GET["reset"] == "success") {
						echo "<p>Check your e-mail!</p>";
					}
					// Alert user that the email is not valid
					else if ($_GET["reset"] == "emailinvalid") {
						echo "<p>E-mail is not recognized</p>";
					}
				}
			?>
		</div>
	</main>
	
<?php
	// Include the common footer file to maintain consistency across pages
	require "footer.php";
?>