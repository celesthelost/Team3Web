<?php

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
require ('mysqli_connect.php'); // Connect to the db.

if ($_SESSION['admin'] == 1){
echo '<h1>Add New User</h1>(<a href="register.php">open</a>)';
echo '<h1>Edit User</h1>(<a href="edit.php">open</a>)';
echo '<h1>Delete User</h1>(<a href="delete.php">open</a>)';
echo '<h1>Reset User\'s Password</h1>';

	// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
	$errors = array(); // Initialize an error array.
	
	// Check for a selected user:
	if (empty($_POST['user_name'])) {
		$errors[] = 'Please select a user.';
	} else {
		$un = mysqli_real_escape_string($dbc, trim($_POST['user_name']));
	}
	
	// Check for a password and match against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'Please enter a password.';
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		// Make the query:
		$q = "UPDATE USER SET PASSWORD='$p' WHERE USERNAME='$un';";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '
		<p class="error">User\'s password has been successfully reset.</p>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">User\'s password could not be reset due to a system error.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		include('includes/userchangepassword.html');
		// Include the footer and quit the script:
		include ('includes/footer.html'); 
		exit();
		
	} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p>';
		
	} // End of if (empty($errors)) IF.
}

include('includes/userchangepassword.html');

}
else{
	echo "<p>Sorry $name, you are not authorized to access this page</p>";
}

include ('includes/footer.html');
?>