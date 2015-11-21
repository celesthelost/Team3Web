<?php # Script 10.5 - #5

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('login.php');
	exit();	

}

$page_title = 'Add New Parking Lot';
include ('includes/header.html');

$name = $_SESSION['first_name'];

if ($_SESSION['admin'] == 1){
echo '<h1>Add New Parking Lot</h1>';
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
	if (empty($_POST['lot_latitude'])) {
		$errors[] = 'Lot latitude cannot be blank.';
	} else {
		$lla = mysqli_real_escape_string($dbc, trim($_POST['lot_latitude']));
	}
	
	// Check for a longitude:
	if (empty($_POST['lot_longitude'])) {
		$errors[] = 'Lot longitude cannot be blank.';
	} else {
		$llo = mysqli_real_escape_string($dbc, trim($_POST['lot_longitude']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Add the new lot to the database
		
		// Make the query:
		$q = "INSERT INTO Lots (LotName, Latitude, Longitude) VALUES ('$ln', '$lla', '$llo')";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '<p class="error">New lot has been added.</p>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">An error occured attempting to add new lot to the database.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		

		// Include the footer and quit the script:
		include("includes/parkingaddnewlot.html");	
		echo '<h1>Modify Parking Space Status</h1>(<a href="parkingmodifyspaces.php">open</a>)';
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

include("includes/parkingaddnewlot.html");	

echo '<h1>Modify Parking Space Status</h1>(<a href="parkingmodifyspaces.php">open</a>)';

}
else{
	echo "<p>Sorry $name, you are not authorized to access this page</p>";
}

include ('includes/footer.html');
?>