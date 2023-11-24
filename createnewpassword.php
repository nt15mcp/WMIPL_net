<?php
	if(!isset($_GET["selector"])){
		header("Location home.php");
	}
	require "header.php";
?>


	<main>
		<div class="w3-center w3-wide" style="padding:10px">
			<?php 
				$selector = $_GET["selector"];
				$validator = $_GET["validator"];
				
				if (empty($selector) || empty($validator)) {
					echo "We could not validate your request!";
				}
				else {
					if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ) {
						?>
						
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
	require "footer.php";
?>