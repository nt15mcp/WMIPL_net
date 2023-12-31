<?php
/**
 * Password Reset Request Submission
 *
 * This script handles the submission of a password reset request. It generates a unique token,
 * stores it in the database, sends a password reset email to the user, and redirects accordingly.
 *
 */

// Set alias for namespace and inherit a trait
use PHPMailer\PHPMailer\{PHPMailer,Exception,SMTP};

// Include PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['reset-request-submit'])) {
	// Include the database helper
    require 'dbh.inc.php';

	// Get user email from the form
    $userEmail = $_POST['email'];
	
	// SQL query to check if the email exists
    $sql = "SELECT * FROM logins WHERE email=?";
	$stmt = mysqli_stmt_init($conn);
	
	// Check for SQL query preparation error
    if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: ../pwdreset.php?error=sqlierror");
		exit();
	} else {
		// Execute the SQL query
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		$resultCheck = mysqli_stmt_num_rows($stmt);
		
		// Check if the email exists
        if ($resultCheck === 0) {
			header("Location ../pwdreset.php?reset=emailinvalid");
			exit();
		} else if ($resultCheck > 0) {
			// Generate unique selector and token
            $selector = bin2hex(random_bytes(8));
			$token = random_bytes(32);
			$url = "https://www.wmipl.net/createnewpassword.php?selector=".$selector."&validator=".bin2hex($token);
			$expires = date("U") + 1800;			
			
			// Delete any existing entries for the user's email
            $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?";
			$stmt = mysqli_stmt_init($conn);
			
			// Check for SQL query preparation error
            if (!mysqli_stmt_prepare($stmt, $sql)) {
				header("Location: ../pwdreset.php?reset=sqlierror");
				exit();
			} else {
				// Execute the SQL query
                mysqli_stmt_bind_param($stmt, "s", $userEmail);
				mysqli_stmt_execute($stmt);
			}

			// Insert new entry for password reset
            $sql = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?)";
			$stmt = mysqli_stmt_init($conn);
			
			// Check for SQL query preparation error
            if (!mysqli_stmt_prepare($stmt, $sql)) {
				header("Location: ../pwdreset.php?reset=sqlierror");
				exit();
			} else {
				// Hash the token before storing in the database
                $hashedToken = password_hash($token, PASSWORD_BCRYPT);
				mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
				mysqli_stmt_execute($stmt);
				
				// Prepare and send password reset email
                $to = $userEmail;
				$subject = "Reset your password for WMIPL.NET";
				$message = '<p>We received a password reset request.  The link to reset your password is below.  If you did not make this request, you can ignore this email</p>';
				$message .= '<p>Here is your password reset link: </br>';
				$message .= '<a href="' . $url . '">' . $url . '</a></p>';
				
				$headers = "From: Admin <NoReply.wmipl@gmail.com>\r\n";
				$headers .= "Reply-To: NoReply.wmipl@gmail.com>\r\n";
				$headers .= "Content-type: text/html\r\n";
				
				// Read sensitive data from the configuration file
                $ini = parse_ini_file('/home/u437830502/domains/wmipl.net/Configs/app.ini');
				// Alternative path for local development (uncomment if needed)
				// $ini = parse_ini_file('C:\xampp\htdocs\wmipl_net\app.ini');
				
				//Create a new PHPMailer instance
				$mail = new PHPMailer;
				$mail->isSMTP(); // Use SMTP
				$mail->SMTPDebug = 0; // Disable debugging. 1 = client messages, 2 = client and server messages
				$mail->Host = $ini['email_host']; // SMTP host
				$mail->Port = $ini['email_port']; // SMTP port
				$mail->SMTPSecure =  PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
				$mail->SMTPAuth = true; // Enable SMTP authentication
				$mail->Username = $ini['email_user']; // SMTP username
				$mail->Password = $ini['email_pword']; // SMTP password
				$mail->setFrom($ini['email_user'], 'Admin WMIPL');
				$mail->addReplyTo($ini['email_user'], 'Admin WMIPL');
				$mail->addAddress($to);
				$mail->Subject = $subject;
				$mail->isHTML(True);
				$mail->Body = $message;
				
				// Send the email and check for errors
                if (!$mail->send()) {
					$mailError = $mail->ErrorInfo;
					$mailStatus = false;
				} else {
					$mailStatus = true;
				}
				
				function save_mail($mail)
				{
					// Set the IMAP path for the 'Sent Mail' folder on Gmail
    				$path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";
					
					// Open an IMAP connection using the provided credentials
   					$imapStream = imap_open($path, $mail->Username, $mail->Password);
					
					// Append the sent email message to the 'Sent Mail' folder
    				$result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
					
					// Close the IMAP connection
    				imap_close($imapStream);
					
					// Return the result indicating success or failure
    				return $result;
				}
			}	
		}
	}
	
	// Close database connections
    mysqli_stmt_close($stmt);
	mysqli_close($conn);
	
	// Redirect based on email status
    if ($mailStatus) {
		header("Location:  ../pwdreset.php?reset=success");
		exit();
	} else {
		header("Location:  ../pwdreset.php?reset=error&error=".$mailError);
		exit();
	}
} else {
	// Redirect to the home page if the form is not submitted
    header("Location: ../index.php");
	exit();
}
?>