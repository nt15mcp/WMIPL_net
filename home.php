<?php
$urlString = '';
foreach ($_GET as $key => $value) {
	if ($urlString === '') {
		$urlString = '?'.$key.'='.$value;
	}else{
		$urlString = $urlString.'&'.$key.'='.$value;
	}
}
header("Location: index.php".$urlString);