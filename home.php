<?php
/**
 * Home page for WMIPL.net
 * 
 * PHP script for constructing a query string from the parameters passed in the GET
 * request and redirects the user to the 'index.php' page with the constructed
 * query string.
 */

// Initialize an empty string to store the constructed query string
$urlString = '';

// Iterate through each key-value pair in the $_GET superglobal array
foreach ($_GET as $key => $value) {
	// Check if $urlString is empty
    if ($urlString === '') {
		// If $urlString is empty, append the first key-value pair with '?'
        $urlString = '?'.$key.'='.$value;
	}else{
		// If $urlString is not empty, append subsequent key-value pairs with '&'
        $urlString = $urlString.'&'.$key.'='.$value;
	}
}

// Redirect the user to the 'index.php' page with the constructed query string
header("Location: index.php".$urlString); 

// Note: This code essentially captures all the parameters from the current URL and
// constructs a new URL with the same parameters, redirecting the user to the 'index.php' page.
// This can be useful in scenarios where the URL parameters need to be preserved during a redirect.