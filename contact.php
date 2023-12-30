<?php
// Need to start a new session if necessary and track what page we are on for this session 
	session_start();
	$_SESSION['page']="contact";
	require "header.php"; // Use common header file so no need to repeat for each page
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