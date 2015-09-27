<?php # Script 10.5 - #5

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('login.php');
	exit();	

}

$page_title = 'Admin Page';
include ('includes/header.html');
echo '<h1>Manage Parkings</h1>';

if ($_SESSION['admin'] == 1){
	echo "Welcome Admin!";
}
else{
	$name = $_SESSION['first_name'];
	echo "<p>Sorry $name, you are not authorized to access this page</p>";
}

include ('includes/footer.html');
?>