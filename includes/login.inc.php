<?php
session_start();
if(!isset($_SESSION['page'])){
	$_SESSION['page'] = 'home';
}

if (isset($_POST['login-submit'])) {
	
	require "dbh.inc.php";
	
	$emailusername = $_POST['username'];
	$password = $_POST['password'];
	
	if (empty($emailusername) || empty($password)) {
		header("Location: ../".$_SESSION['page'].".php?error=emptyfields&username=".$emailusername);
		exit();
	}
	else {
		
		$sql = "SELECT * FROM logins WHERE username=? OR email=?";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../".$_SESSION['page'].".php?error=sqlierror");
			exit();
		}
		else {
			mysqli_stmt_bind_param($stmt, "ss", $emailusername, $emailusername);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			if ($row = mysqli_fetch_assoc($result)) {
				$pwdCheck = password_verify($password, $row['Password']);
				if ($pwdCheck == false) {
					header("Location: ../".$_SESSION['page'].".php?error=wrongpwd");
					exit();
				}
				else if ($pwdCheck == true) {
					$_SESSION['userID'] = $row['id'];
					$_SESSION['userName'] = $row['username'];
					$_SESSION['email'] = $row['email'];
					$sql = "SELECT * FROM executives WHERE user_id=".$_SESSION['userID'];
					$stmt = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt, $sql)) {
						header("Location: ../".$_SESSION['page'].".php?error=sqlierror");
						exit();
					}
					else {
						mysqli_stmt_execute($stmt);
						$result = mysqli_stmt_get_result($stmt);
						if ($row = mysqli_fetch_assoc($result)) {
							$_SESSION['executive'] = $row['title'];
						}
					}
					header("Location: ../".$_SESSION['page'].".php?login=success");
					exit();
				}
				else {
					header("Location: ../".$_SESSION['page'].".php?error=wrongpwd");
				}
			}
			else {
				header("Location: ../".$_SESSION['page'].".php?error=nouser");
				exit();
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else {
	header("Location: ../".$_SESSION['page'].".php");
	exit();
}
	