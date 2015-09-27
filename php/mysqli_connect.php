<?php # Script 9.2 - mysqli_connect.php

// This file contains the database access information. 
// This file also establishes a connection to MySQL, 
// selects the database, and sets the encoding.

// Set the database access information as constants:
DEFINE ('DB_USER', 'Group3Master');
DEFINE ('DB_PASSWORD', 'Group3Rocks!');
DEFINE ('DB_HOST', 'group3dbinstance.cytzj5hx6rvj.us-west-2.rds.amazonaws.com');
DEFINE ('DB_NAME', 'PARKINGAPP');

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');