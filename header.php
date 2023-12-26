<!doctype html>
<!-- Common header for all pages -->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta name="theme-color" content="#000000"/>
	<link href="css/w3.css" rel="stylesheet" type="text/css" media="all"/>
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<title id="pageTitle">WMIPL</title>
	<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png"/>
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png"/>
	<meta name="msapplication-TileColor" content="#FFFFFF"/>
    <meta name="msapplication-TileImage" content="img/favicon-144.png"/>
  </head>
  <!-- At some point I'll want to change the background, it looks old -->
  <body>
    
	
	<header>
	<!-- Provide site navigation bar -->
		<nav class="w3-bar w3-black">
			<ul>
				<li class="w3-button w3-bar-item w3-hover-blue" 
					<?php 
						// Dynamically apply an underline to the current page
						if(isset($_SESSION['page'])){if($_SESSION['page']=='home'){echo 'style="border-bottom:solid 2px blue;"';}}
					?>
					>
					<a style="text-decoration:none" href="index.php">
						Home
					</a>
				</li>
				<li class="w3-button w3-bar-item w3-hover-blue" 
					<?php 
						// Dynamically apply an underline to the current page
						if(isset($_SESSION['page'])){if($_SESSION['page']=='about'){echo 'style="border-bottom:solid 2px blue;"';}}
					?>
					>
					<a style="text-decoration:none" href="about.php">
						About
					</a>
				</li>
				<li class="w3-button w3-bar-item w3-hover-blue" 
					<?php 
						// Dynamically apply an underline to the current page
						if(isset($_SESSION['page'])){if($_SESSION['page']=='scores'){echo 'style="border-bottom:solid 2px blue;"';}}
					?>
					>
					<a style="text-decoration:none" href="scores.php">
						Scores
					</a>
				</li>
				<li class="w3-button w3-bar-item w3-hover-blue" 
					<?php 
						// Dynamically apply an underline to the current page
						if(isset($_SESSION['page'])){if($_SESSION['page']=='leaders'){echo 'style="border-bottom:solid 2px blue;"';}}
					?>
					>
					<a style="text-decoration:none" href="leaders.php">
						Leaders
					</a>
				</li>
				<li class="w3-button w3-bar-item w3-hover-blue" 
					<?php 
						// Dynamically apply an underline to the current page
						if(isset($_SESSION['page'])){if($_SESSION['page']=='roster'){echo 'style="border-bottom:solid 2px blue;"';}}
					?>
					>
					<a style="text-decoration:none" href="roster.php">
						Roster
					</a>
				</li>
				<li class="w3-button w3-bar-item w3-hover-blue" 
					<?php 
						// Dynamically apply an underline to the current page
						if(isset($_SESSION['page'])){if($_SESSION['page']=='rules'){echo 'style="border-bottom:solid 2px blue;"';}}
					?>
					>
					<a style="text-decoration:none" href="rules.php">
						Rules
					</a>
				</li>
				<li class="w3-button w3-bar-item w3-hover-blue" 
					<?php 
						// Dynamically apply an underline to the current page
						if(isset($_SESSION['page'])){if($_SESSION['page']=='schedule'){echo 'style="border-bottom:solid 2px blue;"';}}
					?>
					>
					<a style="text-decoration:none" href="schedule.php">
						Schedule
					</a>
				</li>
				<li class="w3-button w3-bar-item w3-hover-blue" 
					<?php 
						// Dynamically apply an underline to the current page
						if(isset($_SESSION['page'])){if($_SESSION['page']=='contact'){echo 'style="border-bottom:solid 2px blue;"';}}
					?>
					>
					<a style="text-decoration:none" href="contact.php">
						Contact
					</a>
				</li>
			</ul>
			<div style="float:right">
				<?php
					// This code will provide authorized users extra functionality
					if (isset($_SESSION['userID'])) {
						//echo '
						//	<div class="w3-dropdown-hover" style="width:100%">
						//		<button class="w3-btn" >'.$_SESSION['userName'].'</button>
						//		<div class="w3-dropdown-content" style="right:5px;background-color:black">
									echo '<form style="width:min-content;background-color:black;" action="includes/logout.inc.php" method="post">
										<button class="w3-btn w3-hover-blue" type="submit" name="logout-submit">Logout</input>
									</form>' ;
						//			<form style="width:min-content" action="includes/edit.inc.php" method="post">
						//				<button class="w3-btn w3-hover-blue" type="submit" name="edit-profile">Edit Profile</button>
						//			</form>
						//		</div>
						//	</div>' ;
					}
					else {
						//This code gives someone the ability to log in
						echo '<form action="includes/login.inc.php" method="post">
						<input type="text" name="username" placeholder="Username" required>
						<input type="password" name="password" placeholder="Password" required>
						<button type="submit" name="login-submit">Login</button> 
						</form>';
						if (isset($_GET['error'])) {
							echo '<p style="color:red;"><strong>Username or Password are incorrect!<strong></p>';
						}
						echo '<a href="signup.php">Signup</a>' ;
					}					
				?>
			</div>
		</nav>
	</header>
