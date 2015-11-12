<?php # Script 10.5 - #5

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('login.php');
	exit();	

}

$page_title = 'NKU Parking - User Management';
include ('includes/header.html');

$name = $_SESSION['first_name'];

if ($_SESSION['admin'] == 1){
echo '<h1>Add New User</h1>(<a href="registerbyadmin.php">open</a>)';
echo '<h1>Edit User</h1>(<a href="edit.php">open</a>)';
echo '<h1>Delete User</h1>(<a href="delete.php">open</a>)';
	
	
	
	
	
	
		
	// Check for form submission:
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
		require ('mysqli_connect.php'); // Connect to the db.
			
		$errors = array(); // Initialize an error array.
		
		
		// Check for an email address:
		if (empty($_POST['email'])) {
			$errors[] = 'You forgot to enter your email address.';
		} else {
			$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
		}
		
		
		
		if (empty($errors)) { // If everything's OK.
		
			// Register the user in the database...
			
			// Make the query:
			$q = "DELETE FROM USER WHERE USERNAME='$e';";
				
			$r = @mysqli_query ($dbc, $q); // Run the query.
			if ($r) { // If it ran OK.
			
				// Print a message:
				echo '
			<p class="error">User has been been deleted.</p><p><br /></p>';	
			
			} else { // If it did not run OK.
				
				// Public message:
				echo '<h1>System Error</h1>
				<p class="error">User profile could not be deleted due to a system error.</p>'; 
				
				// Debugging message:
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
							
			} // End of if ($r) IF.
			
	
			// Include the footer and quit the script:
			echo '<h1>Reset User\'s password</h1>(<a href="reset.php">open</a>)';
			include ('includes/footer.html'); 
			exit();
			
		} else { // Report the errors.
		
			echo '<h1>Error!</h1>
			<p class="error">The following error(s) occurred:<br />';
			foreach ($errors as $msg) { // Print each error.
				echo " - $msg<br />\n";
			}
			echo '</p><p>Please try again.</p><p><br /></p>';
			
		} // End of if (empty($errors)) IF.
		
	
	}
?>
<form action="delete.php" method="POST">
	<p>Email Address: <input type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </p>
	<p><input type="submit" name="submit" value="Delete From Records" /></p>
</form>


<?php	

echo '<h1>Reset User\'s password</h1>(<a href="reset.php">open</a>)';

}
else{
	echo "<p>Sorry $name, you are not authorized to access this page</p>";
}

include ('includes/footer.html');
?>