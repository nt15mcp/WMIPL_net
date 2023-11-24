<?php
	session_start();
	$_SESSION['page']="roster";
	require "header.php";
?>

	<main>
		<div class="w3-wide" style="padding:10px">
			<?php
				require "includes/textarea.inc.php";
				
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
				else {
					echo $content;
				}
			?>
		</div>
	</main>
<?php
	require "footer.php";
?>