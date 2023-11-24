<?php
	session_start();
	$_SESSION['page']="leaders";
	require "header.php";
?>

	<main>
		<div class="w3-center ws-center" style="padding:10px">
			<h1>Leader Board</h1>
		</div>
		<div class="w3-wide w3-center" style="padding:10px">
			<iframe title="LeaderFrame" width="100%" height="536" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vTffb80J2aEHWbgrlJbljWvDduwYXecsoD6JKWYU9r19jN65GTRID0BQzWSliaM5klPO9APaMWT1As-/pubhtml?widget=true&amp;amp;headers=false"></iframe>
		</div>
	</main>
<?php
	require "footer.php";
?>