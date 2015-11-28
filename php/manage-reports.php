<?php # Script 10.5 - #5

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('login.php');
	exit();	

}

$page_title = 'NKU Parking - Reports';
include ('includes/header.html');

$name = $_SESSION['first_name'];

if ($_SESSION['admin'] == 1){
echo '<h1>Parking Lot Usage</h1>(<a href="reportparkinglotusage.php">open</a>)';
echo '<h1>User Parking Report</h1>(<a href="reportuserparkingusage.php">open</a>)';

}
else{
	echo "<p>Sorry $name, you are not authorized to access this page</p>";
}

include ('includes/footer.html');
?>