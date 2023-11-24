<?php
	// Need to start a new session if necessary and track what page we are on for this session 
	session_start();
	$_SESSION['page']="leaders";
	require "header.php"; // Use common header file so no need to repeat for each page
?>

	<main>
		<div class="w3-center ws-center" style="padding:10px">
			<h1>Leader Board</h1>
		</div>
		<div class="w3-wide w3-center" style="padding:10px">
		<!-- Displays the leaderboard Google Sheet -->
			<iframe title="LeaderFrame" width="100%" height="536" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vTffb80J2aEHWbgrlJbljWvDduwYXecsoD6JKWYU9r19jN65GTRID0BQzWSliaM5klPO9APaMWT1As-/pubhtml?widget=true&amp;amp;headers=false"></iframe>
		</div>
	</main>
<?php
	require "footer.php"; // Use common footer file so no need to repeat for each page
?>