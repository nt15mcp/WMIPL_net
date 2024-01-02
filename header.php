<!doctype html>
<!-- Common header for all pages -->
<html lang="en">
	<head>
		<!-- Set the character set and viewport for responsive design -->
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="theme-color" content="#000000"/>
		<?php
		/**
		*  Given a file, i.e. /css/base.css, replaces it with a string containing the
		*  file's mtime, i.e. /css/base.1221534296.css.
		*
		*  @param $file  The file to be loaded. works on all type of paths.
		*/
		function auto_version($file) {
		if($file[0] !== '/') {
			$file = rtrim(str_replace(DIRECTORY_SEPARATOR, '/', dirname($_SERVER['PHP_SELF'])), '/') . '/' . $file;
		}
		
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
		return $file;
		
		$mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
		return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
		}
		?>

		<!-- Include the stylesheet with auto versioning to ensure cache busting -->
		<link href="<?php echo auto_version('css/w3.css')?>" rel="stylesheet" type="text/css" media="all"/>

		<!-- Include CKEditor library for rich text editing -->
		<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
		
		<!-- Set the title of the page -->
		<title id="pageTitle">WMIPL</title>
		
		<!-- Add various icons for different devices -->
		<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png"/>
		<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png"/>
		<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png"/>
		<meta name="msapplication-TileColor" content="#FFFFFF"/>
		<meta name="msapplication-TileImage" content="img/favicon-144.png"/>
	</head>
  
	<!-- Body of the HTML document -->
	<body>
    
	<!-- Site Header Section -->
    <header>
		<!-- Provide site navigation bar -->
		<nav class="w3-bar w3-black">
			<ul>
				<!-- Navigation links for different pages -->
                <!-- Dynamically apply an underline to the current page -->
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

			<!-- User authentication section -->
			<div style="float:right">
				<?php
					// Display different content based on user authentication status
					if (isset($_SESSION['userID'])) {
						// Display logout button for authenticated users
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
						// Display login form for non-authenticated users
						echo '<form action="includes/login.inc.php" method="post">
						<input type="text" name="username" placeholder="Username" required>
						<input type="password" name="password" placeholder="Password" required>
						<button type="submit" name="login-submit">Login</button> 
						</form>';
						
						// Display error message if login attempt failed
						if (isset($_SESSION['error'])) {
							echo '<p style="color:red;"><strong>Username or Password are incorrect!<strong></p>';
						}

						// Display signup link for new users
						echo '<a href="signup.php">Signup</a>' ;
					}					
				?>
			</div>
		</nav>
	</header>
