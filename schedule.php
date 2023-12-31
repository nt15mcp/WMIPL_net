<?php
/**
 * Schedule Page
 *
 * PHP script for the schedule page. Initiates a new session, sets the 'page'
 * session variable to 'schedule', and includes a common header file. Displays
 * a container with schedule content retrieved from the database. Allows executive
 * members to edit the content in a textarea with CKEditor integration.
 */
	// Start a new session and track the current page
	session_start();
	$_SESSION['page']="schedule";

	// Include a common header file to avoid repetition
	require "header.php";
?>

<main>
	<!-- Container for displaying schedule content -->
	<div class="w3-center schedule-container" style="padding:10px">
		<?php
			// Include text area content from the database
			require "includes/textarea.inc.php"; // Get text area from database for display
			
			// Allow executive members to edit the text area in the browser
			if (isset($_SESSION['executive'])) {
				echo '<form action="includes/form-handler.inc.php" method="post">
				<textarea rows=10 style="width:100%" name="content">';
				
				// Display the current content in the textarea
				echo $content;
				
				echo '</textarea>
				<script type="text/javascript">
					CKEDITOR.replace( \'content\' );
				</script>
				<button type="submit" name="text-submit">Submit</button>
				</form>';
				
			} else {
				// Display the content for regular users
				echo $content;
			}
		?>
	</div>
</main>

<?php
	// Include a common footer file to avoid repetition
	require "footer.php";
?>