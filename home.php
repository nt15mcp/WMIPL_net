<?php
// Bad programmer (me) strikes again as I don't remember what this is doing
$urlString = '';
foreach ($_GET as $key => $value) {
	if ($urlString === '') {
		$urlString = '?'.$key.'='.$value;
	}else{
		$urlString = $urlString.'&'.$key.'='.$value;
	}
}
header("Location: index.php".$urlString); // This auto-redirects to the index page