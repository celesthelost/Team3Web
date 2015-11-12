<?php
session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('login.php');
	exit();	

}

$page_title = 'NKU Parking - Reports';
include ('includes/header.html');

echo "<p>This page has not been implemented yet.</p>";
echo "<p>Please check back later.</p>";

include ('includes/footer.html');
?>