<?php

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('login.php');
	exit();	

}

$page_title = 'Admin Page';
include ('includes/header.html');
$name = $_SESSION['first_name'];
require ('mysqli_connect.php'); // Connect to the db.

if ($_SESSION['admin'] == 1){

	echo '<h1>Add New User</h1>(<a href="register.php">open</a>)';
	echo '<h1>Edit User</h1>';
	
	// Check for form submission:
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
		$errors = array(); // Initialize an error array.
		
		
		// Verify username was entered
		if (empty($_POST['user_name'])) {
			$errors[] = 'You forgot to enter a username.';
		} else {
			$un = mysqli_real_escape_string($dbc, trim($_POST['user_name']));
		}
		
		// Check for a password and match against the confirmed password:
		$isAdmin = 0;
		if ($_POST['isAdmin'] == "yes") {
			$isAdmin = 1;
		}elseif($_POST['isAdmin'] == "no"){
			$isAdmin = 0;
		} else {
			$errors[] = 'Your did not select YES/No for admin';
		}
		
		if (empty($errors)) { // If everything's OK.
		
			// Register the user in the database...
			
			// Make the query:
			if ($isAdmin){
				$q = "UPDATE USER SET Admin='1' WHERE USERNAME='$un';";	
			}else{
				$q = "UPDATE USER SET Admin='0' WHERE USERNAME='$un';";	
			}
				
			$r = @mysqli_query ($dbc, $q); // Run the query.
			if ($r) { // If it ran OK.
			
				// Print a message:
				echo '
			<p class="error">User profile has been updated.</p>';	
			
			} else { // If it did not run OK.
				
				// Public message:
				echo '<h1>System Error</h1>
				<p class="error">User profile could not be updated due to a system error.</p>'; 
				
				// Debugging message:
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
							
			} // End of if ($r) IF.
			
			include('includes/useredituser.html');
			// Include the footer and quit the script:
			echo '<h1>Delete User</h1>(<a href="delete.php">open</a>)';
			echo '<h1>Reset User\'s Password</h1>(<a href="reset.php">open</a>)';
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

	include('includes/useredituser.html');
	echo '<h1>Delete User</h1>(<a href="delete.php">open</a>)';
	echo '<h1>Reset User\'s Password</h1>(<a href="reset.php">open</a>)';

}
else{
	echo "<p>Sorry $name, you are not authorized to access this page</p>";
}

include ('includes/footer.html');
?>