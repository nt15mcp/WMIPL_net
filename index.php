<?php
/**
 * Index page for WMIPL.net
 * 
 * PHP script for the home page of WMIPL.net. Serves as the home page of the website.
 * Handles session initiation, sets the current page in the session data,
 * includes a common header file, displays a main content area, and allows
 * executive members to edit the content.
 */

	// Start a new session or resume the existing session
	session_start();

	// Set the current page to "home" in the session data
	$_SESSION['page']="home";

	// Include the common header file to maintain consistency across pages
	require "header.php";

?>

	<main>
		<div class="home-container" style="padding:10px; margin:auto; width:95%; overflow:auto;">
			<?php
				// Include a script to retrieve text area content from the database
        		require "includes/textarea.inc.php"; // Get text area from database for display
				
				// Check if the user is an executive member to allow editing of the text area
				if (isset($_SESSION['executive'])) {
					echo '
						<form action="includes/form-handler.inc.php" method="post">
						<textarea rows=10 style="width:100%" name="content">
					';
					
					// Display the current content in the textarea for editing
					echo $content;
					
					echo '
						</textarea>
						<script type="text/javascript">
							CKEDITOR.replace( \'content\' );
						</script>
						<button type="submit" name="text-submit">Submit</button>
						</form>
					';
					
				} else {
					// Display the content without editing options for non-executive members
					echo $content;
				}
			?>
		</div>
	</main>
<?php
	// Include the common footer file to maintain consistency across pages
	require "footer.php";
?>