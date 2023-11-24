<?php
	// Need to start a new session if necessary and track what page we are on for this session 
	session_start();
	if (isset($_SESSION['page'])){
		unset($_SESSION['page']);
	}
	require "header.php"; // Use common header file so no need to repeat for each page
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
	require "footer.php"; // Use common footer file so no need to repeat for each page
?>