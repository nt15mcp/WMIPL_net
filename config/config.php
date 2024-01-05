<?php
/**
 * Database Connection Module
 *
 * This module establishes a connection to the MySQL database using
 * configuration parameters stored in an INI file. It provides a
 * reusable connection object for other parts of the application.
 */

// Parse the INI configuration file to retrieve database connection details
// $ini = parse_ini_file('/home/u437830502/domains/wmipl.net/config/app.ini');
// Alternative path for local development (uncomment if needed)
$ini = parse_ini_file('C:\xampp\htdocs\wmipl_net\config\app.ini');

// Retrieve database connection parameters from the parsed INI file
$servername = $ini['db_server'];
$dbusername = $ini['db_user'];
$dbpassword = $ini['db_pword'];
$database = $ini['db_name'];

// Establish a connection to the MySQL database
try {
	$db = new PDO('mysql:host='.$servername.';dbname='.$database,$dbusername,$dbpassword, [PDO::ATTR_EMULATE_PREPARES => false]);
} catch(\PDOException $e) {
	throw new \PDOException($e->getMessage(), $e->getCode());
}

// If the connection is successful, the $db variable can be used for database operations