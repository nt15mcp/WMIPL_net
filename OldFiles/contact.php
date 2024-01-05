<?php
/**
 * Contact Page
 * 
 * PHP script for the 'contact' page. Handles session initiation,
 * includes common header and footer files, and displays content
 * from the database. If the user is an executive member, provides
 * an option to edit and submit the content using CKEditor.
 */
	// Need to start a new session if necessary and track what page we are on for this session 
	session_start();

	// Set the current page to "contact" in the session data
	$_SESSION['page']="contact";

	// Include the common header file to maintain consistency across pages
	require "header.php";
?>
	<main>
		<div class="w3-center contact-container" style="padding:10px">
			<?php
				require "includes/textarea.inc.php"; // Get text area from database for display
				
				// Allow executive members to edit the text area in the browser
				if (isset($_SESSION['executive'])) {
					echo '<form action="includes/form-handler.inc.php" method="post">
					<textarea rows=10 style="width:100%" name="content">';
					
					echo $content;
					
					echo '</textarea>
					<script type="text/javascript">
						CKEDITOR.replace( \'content\' );
					</script>
					<button type="submit" name="text-submit">Submit</button>
					</form>';
					
				}
				// Only display the content because the viewer is not an execituve member
				else {
					echo $content;
				}
			?>
		</div>
	</main>
<?php
	require "footer.php"; // Use common footer file so no need to repeat for each page
?> 