<?php # Script 10.5 - #5

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('login.php');
	exit();	

}

$page_title = 'NKU Parking - Manage Parking';
include ('includes/header.html');

$name = $_SESSION['first_name'];

if ($_SESSION['admin'] == 1){
echo '<h1>Add New Parking Lot</h1>(<a href="parkingaddnewlot.php">open</a>)';
echo '<h1>Modify Parking Space Status</h1>(<a href="parkingmodifyspaces.php">open</a>)';

}
else{
	echo "<p>Sorry $name, you are not authorized to access this page</p>";
}

include ('includes/footer.html');
?>