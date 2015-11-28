<?php # Script 10.5 - #5

session_start(); // Start the session.


// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('login.php');
	exit();	

}

require ('mysqli_connect.php');// Connect to the db.

$page_title = 'Parking Lot Usage Report';
include ('includes/header.html');
echo '<h1>Parking Lot Usage</h1>';
include('includes/reportparkinglotusage.html');

$name = $_SESSION['first_name'];

if ($_SESSION['admin'] == 1){
	// Check for form submission:
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
	$errors = array(); // Initialize an error array.
	
	// Check for a lot name:
	if (empty($_POST['lot_name'])) {
		$errors[] = 'Please select a lot to run usage report on.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['lot_name']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Add the new lot to the database
		
		// Make the query:
		$q = "SELECT * FROM Spots WHERE SpotLot='$ln'";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			$totalSpots = 0;
			$spotsClosed = 0;
			$spotsReserved = 0;
			$spotsUnavailable = 0;
			$spotsAvailable = 0;

			while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC)){
				$totalSpots++;
				if ($row['SpotStatus'] == 'available'){
					$spotsAvailable++;
				} else if ($row['SpotStatus'] == 'reserved'){
					$spotsReserved++;
				} else if ($row['SpotStatus'] == 'closed'){
					$spotsClosed++;
				} else if ($row['SpotStatus'] == 'unavailable'){
					$spotsUnavailable++;
				}
			}

			echo   '<table id="report">
						<tr>
							<td id="reportname" colspan="2">'.$ln.' Usage</td>
						</tr>
						<tr>
							<th>Total Spots</th>
							<td id="reportnumber">'.$totalSpots.'</td>
						</tr>
						<tr>
							<th>Reserved</th>
							<td id="reportnumber">'.$spotsReserved.'</td>
						</tr>
						<tr>
							<th>Unavailable</th>
							<td id="reportnumber">'.$spotsUnavailable.'</td>
						</tr>
						<tr>
							<th>Closed</th>
							<td id="reportnumber">'.$spotsClosed.'</td>
						</tr>
						<tr id="reportresult">
							<th>Available</th>
							<td id="reportnumber">'.$spotsAvailable.'</td>
						</tr>
					</table>';		

		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">An error occured attempting to retrive parking usage statistics from the database.</p>'; 
			
			// Debugging message:
			echo '<p>'.mysqli_error($dbc).'Query: '.$q.'</p>';
						
		} // End of if ($r) IF.
		

		// Include the footer and quit the script:
		echo '<h1>User Parking Report</h1>(<a href="reportuserparkingusage.php">open</a>)';
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

}
else{
	echo "<p>Sorry $name, you are not authorized to access this page</p>";
}
echo '<h1>User Parking Report</h1>(<a href="reportuserparkingusage.php">open</a>)';
include ('includes/footer.html');
?>