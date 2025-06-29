<?php # mysqli_connect.php

// This file contains the database access information. 
// This file also establishes a connection to MySQL, 
// selects the database, and sets the encoding.

// Set the database access information as constants:
// Use Docker environment variables if available, otherwise use defaults for XAMPP
DEFINE ('DB_USER', getenv('DB_USER') ?: 'root');
DEFINE ('DB_PASSWORD', getenv('DB_PASS') ?: '');
DEFINE ('DB_HOST', getenv('DB_HOST') ?: 'localhost');
DEFINE ('DB_NAME', getenv('DB_NAME') ?: 'cateringdata');


// Make the connection:
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');