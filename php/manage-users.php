<?php # Script 10.5 - #5

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('login.php');
	exit();	

}

$page_title = 'Registering New User';
include ('includes/header.html');

$name = $_SESSION['first_name'];

if ($_SESSION['admin'] == 1){
echo '<h1>Add New User</h1>(<a href="register.php">open</a>)';
echo '<h1>Edit User</h1>(<a href="edit.php">open</a>)';
echo '<h1>Delete User</h1>(<a href="delete.php">open</a>)';
echo '<h1>Reset User\'s password</h1>(<a href="reset.php">open</a>)';

}
else{
	echo "<p>Sorry $name, you are not authorized to access this page</p>";
}

include ('includes/footer.html');
?>