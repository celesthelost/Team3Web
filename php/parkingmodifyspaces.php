<?php # Script 10.5 - #5

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('login.php');
	exit();	

}

$page_title = 'Modify Parking Space Status';
include ('includes/header.html');
echo '<h1>Add New Parking Lot</h1>(<a href="parkingaddnewlot.php">open</a>)';
echo '<h1>Modify Parking Space Status</h1>';

$name = $_SESSION['first_name'];

if ($_SESSION['admin'] == 1){
	// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for a lot name:
	if (empty($_POST['lot_name'])) {
		$errors[] = 'Lot name cannot be blank.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['lot_name']));
	}
	
	// Check for a latitude:
	if (empty($_POST['space_number'])) {
		$errors[] = 'Space number cannot be blank.';
	} else {
		$sn = mysqli_real_escape_string($dbc, trim($_POST['space_number']));
	}
	
	// Check for a longitude:
	if (empty($_POST['space_status'])) {
		$errors[] = 'Space status cannot be blank.';
	} else {
		$ss = mysqli_real_escape_string($dbc, trim($_POST['space_status']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Add the new lot to the database
		
		// Make the query:
		$q = "UPDATE Spots SET SpotStatus='$ss' WHERE SpotNumber='$sn' AND SpotLot='$ln'";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '<p class="error">Space status has been updated.</p>';

		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">An error occured attempting to update the space status in the database.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		

		// Include the footer and quit the script:
		echo '<h1>Add New Parking Lot</h1>(<a href="parkingaddnewlot.php">open</a>)';
		include("includes/parkingmodifyspace.html");	
		include ('includes/footer.html'); 
		exit();
		
	} else { // Report the errors.
	
		echo '<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
}

include("includes/parkingmodifyspace.html");	

}
else{
	echo "<p>Sorry $name, you are not authorized to access this page</p>";
}

include ('includes/footer.html');
?>