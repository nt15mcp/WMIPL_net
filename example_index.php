<?php
/**
 * Index page for WMIPL.net
 *
 * PHP script for the home page of WMIPL.net. Serves as the home page of the website.
 * Handles session initiation, sets the current page in the session data,
 * includes a common header file, displays a main content area, and allows
 * executive members to edit the content.
 */

// you shouldn't echo large blocks of static markup. just drop out of php and put the static markup inline

// initialization
// Start a new session or resume the existing session
session_start();

// Include the database connection file
require 'pdo_connection.php'; //"dbh.inc.php";

// if there is a logged in user, retrieve any other user data
if(isset($_SESSION['userID']))
{
	// Retrieve additional information for executive users
	$sql = "SELECT title FROM executives WHERE login_id=?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $_SESSION['userID'] ]);
	if($row = $stmt->fetch())
	{
		$user_data['executive'] = $row['title'];
	}
	
	// if you are going to use any other user data, such as the username, query for that here and add it to the $user_data array
}

// Set the current page to "home" in the session data
$_SESSION['page']="home";

// define mapping of permitted post method form 'action' values to code file names
$post_actions["text-submit"] = "includes/form-handler.inc.php"; // edit (insert new version) page content
$post_actions["logout-submit"] = "includes/logout.inc.php";
$post_actions["login-submit"] = "includes/login.inc.php";

$post = []; // array to hold a trimmed working copy of the form data
$errors = []; // array to hold user/validation errors

// post method form processing
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	// trim all the input data at once
	$post = array_map('trim',$_POST); // if any field is an array, use a recursive trim call-back function here instead of php's trim

	// you should not test if the submit button is set. there are cases where it won't be.
	// instead use a hidden field with a specific value to control what the form processing code does
	// check for a permitted post method form action
	if(isset($post_actions[ $post['action'] ]))
	{
		// require and execute the appropriate file
		require $post_actions[ $post['action'] ];
	}

	// if no errors, success
	if(empty($errors))
	{
		// redirect to the exact same url of the current page to cause a get request - PRG Post, Redirect, Get.
		die(header("Refresh:0"));
	}
}

// get method business logic - get/produce data needed to display the page
// Include script to retrieve text area content from the database
require "includes/textarea.inc.php"; // Get text area content from database for display

// html document
// Include the common header file to maintain consistency across pages
require "header.php";
?>
	<main>
		<div class="home-container" style="padding:10px; margin:auto; width:95%; overflow:auto;">
			<?php
				// Check if the user is an executive member to allow editing of the text area
				if (isset($user_data['executive']))
				{
					// Display any one-time success message
					if(isset($_SESSION['text-submit_success_message']))
					{
						echo '<p style="color:black;"><strong>'.$_SESSION['text-submit_success_message'].'<strong></p>';
						unset($_SESSION['text-submit_success_message']);
					}
					
					// display any errors
					if(!empty($errors))
					{
						echo '<p style="color:red;"><strong>'.implode('<br>',$errors).'<strong></p>';
					}
					
					// note: any white-space characters between the > and < of the textarea tags become part of the submitted content
					// remove the extra white-space here and you should also trim() all user entered data before validating it on the server
					// Display the current content in the textarea for editing
					?>
					<form method="post">
					<input type="hidden" name="action" value="text-submit">
					<textarea rows=10 style="width:100%" name="content"><?=$content?></textarea>
					<script>
						CKEDITOR.replace( 'content' );
					</script>
					<button type="submit">Submit</button>
					</form>
					<?php
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