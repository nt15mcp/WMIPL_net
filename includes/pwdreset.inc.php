<?php
use PHPMailer\PHPMailer\{PHPMailer,Exception,SMTP};

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['reset-request-submit'])) {
	require 'dbh.inc.php';
	$userEmail = $_POST['email'];
	$sql = "SELECT * FROM Login WHERE Email=?";
	$stmt = mysqli_stmt_init($conn);
	//delete this
	//echo 'initializing select</br>email:'.$userEmail.'</br>';
	
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: ../pwdreset.php?error=sqlierror");
		exit();
		//echo 'prepare SELECT failed</br>';
	}
	else {
		mysqli_stmt_bind_param($stmt, "s", $userEmail);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		$resultCheck = mysqli_stmt_num_rows($stmt);
		if ($resultCheck === 0) {
			header("Location ../pwdreset.php?reset=emailinvalid");
			exit();
			//echo $resultCheck.' result check is 0</br>';
		}
		else if ($resultCheck > 0) {
			$selector = bin2hex(random_bytes(8));
			$token = random_bytes(32);
			$url = "https://www.wmipl.net/createnewpassword.php?selector=".$selector."&validator=".bin2hex($token);
			$expires = date("U") + 1800;			
			$sql = "DELETE FROM Pwdreset WHERE pwdResetEmail=?";
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				header("Location: ../pwdreset.php?reset=sqlierror");
				exit();
				//echo 'prepare DELETE failed</br>';
			}
			else {
				mysqli_stmt_bind_param($stmt, "s", $userEmail);
				mysqli_stmt_execute($stmt);
			}
			$sql = "INSERT INTO Pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?)";
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				header("Location: ../pwdreset.php?reset=sqlierror");
				exit();
				//echo 'prepare INSERT failed</br>';
			}
			else {
				$hashedToken = password_hash($token, PASSWORD_BCRYPT);
				mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
				mysqli_stmt_execute($stmt);
				//delete this
				//echo 'attempting email</br>';
				
				$to = $userEmail;
				$subject = "Reset your password for WMIPL.NET";
				$message = '<p>We received a password reset request.  The link to reset your password is below.  If you did not make this request, you can ignore this email</p>';
				$message .= '<p>Here is your password reset link: </br>';
				$message .= '<a href="' . $url . '">' . $url . '</a></p>';
				
				$headers = "From: Admin <NoReply.wmipl@gmail.com>\r\n";
				$headers .= "Reply-To: NoReply.wmipl@gmail.com>\r\n";
				$headers .= "Content-type: text/html\r\n";
				
				
				//Create a new PHPMailer instance
				$mail = new PHPMailer;
				//Tell PHPMailer to use SMTP
				$mail->isSMTP();
				//Enable SMTP debugging
				// 0 = off (for production use)
				// 1 = client messages
				// 2 = client and server messages
				$mail->SMTPDebug = 0;
				//Set the hostname of the mail server
				$mail->Host = 'smtp.gmail.com';
				// use
				//$mail->Host = gethostbyname('smtp.gmail.com');
				// if your network does not support SMTP over IPv6
				//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
				$mail->Port = 587;
				//Set the encryption system to use - ssl (deprecated) or tls
				$mail->SMTPSecure =  PHPMailer::ENCRYPTION_STARTTLS;
				//Whether to use SMTP authentication
				$mail->SMTPAuth = true;
				//Username to use for SMTP authentication - use full email address for gmail
				$mail->Username = "noreply.wmipl@gmail.com";
				//Password to use for SMTP authentication
				$mail->Password = "DefaultAdminPassword";
				//Set who the message is to be sent from
				$mail->setFrom('noreply.wmipl@gmail.com', 'Admin WMIPL');
				//Set an alternative reply-to address
				$mail->addReplyTo('noreply.wmipl@gmail.com', 'Admin WMIPL');
				//Set who the message is to be sent to
				$mail->addAddress($to);
				//Set the subject line
				$mail->Subject = $subject;
				//Read an HTML message body from an external file, convert referenced images to embedded,
				$mail->isHTML(True);
				//convert HTML into a basic plain-text alternative body
				$mail->Body = $message;
				//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
				//Replace the plain text body with one created manually
				//$mail->AltBody = 'This is a plain-text message body';
				//Attach an image file
				//$mail->addAttachment('images/phpmailer_mini.png');
				//$mail->Content-Type('text/html\r\n')
				//send the message, check for errors
				if (!$mail->send()) {
					$mailError = $mail->ErrorInfo;
					$mailStatus = false;
				} else {
					$mailStatus = true;
					//Section 2: IMAP
					//Uncomment these to save your message in the 'Sent Mail' folder.
					#if (save_mail($mail)) {
					#    echo "Message saved!";
					#}
				}
				//Section 2: IMAP
				//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
				//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
				//You can use imap_getmailboxes($imapStream, '/imap/ssl') to get a list of available folders or labels, this can
				//be useful if you are trying to get this working on a non-Gmail IMAP server.
				function save_mail($mail)
				{
					//You can change 'Sent Mail' to any other folder or tag
					$path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";
					//Tell your server to open an IMAP connection using the same username and password as you used for SMTP
					$imapStream = imap_open($path, $mail->Username, $mail->Password);
					$result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
					imap_close($imapStream);
					return $result;
				}
			}	
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	if ($mailStatus) {
		header("Location:  ../pwdreset.php?reset=success");
		exit();
	}
	else {
		header("Location:  ../pwdreset.php?reset=error&error=".$mailError);
		exit();
	}
}
else {
	header("Location: ../index.php");
	exit();
}