<?php # Script 10.5 - #5

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('login.php');
	exit();	

}

$page_title = 'Profile';
include ('includes/header.html');
echo '<h1>User Profile</h1>';

$first = $_SESSION['first_name'];
$last = $_SESSION['last_name'];
$status = $_SESSION['admin'];

echo "<p>Name: $first $last.</p>";
if ($status == 0){
	echo "<p>Status: Not Admin</p>";
} else{
	echo "<p>Status: Admin</p>";
}

include ('includes/footer.html');
?>