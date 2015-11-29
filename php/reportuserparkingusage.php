<?php

session_start(); // Start the session.


// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('login.php');
	exit();	

}

require ('mysqli_connect.php');// Connect to the db.

$page_title = 'User Parking Report';
include ('includes/header.html');
echo '<h1>Parking Lot Usage</h1>(<a href="reportparkinglotusage.php">open</a>)';
echo '<h1>User Parking Report</h1>';
include ('includes/reportuserparkingusage.html');

$name = $_SESSION['first_name'];

if ($_SESSION['admin'] == 1){
	// Check for form submission:
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
	$errors = array(); // Initialize an error array.
	
	// Check for a lot name:
	if (empty($_POST['user_name'])) {
		$errors[] = 'Please select a user to run usage report on.';
	} else {
		$un = mysqli_real_escape_string($dbc, trim($_POST['user_name']));
	}
	if (empty($_POST['lot_name'])) {
		$errors[] = 'Please select a lot to run usage report on.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['lot_name']));
	}
	if (empty($_POST['start_date'])) {
		$errors[] = 'Please select a start date.';
	} else {
		$sd = mysqli_real_escape_string($dbc, trim($_POST['start_date']));
	}
	if (empty($_POST['end_date'])) {
		$errors[] = 'Please select an end date.';
	} else {
		$ed = mysqli_real_escape_string($dbc, trim($_POST['end_date']));
	}
	
	if (empty($errors)) { // If everything's OK.

		// Reorganize the date into yyyy-dd-mm
		$sd_array = explode("/", $sd);
		$sd = $sd_array[2]."-".$sd_array[0]."-".$sd_array[1];
		$ed_array = explode("/", $ed);
		$ed = $ed_array[2]."-".$ed_array[0]."-".$ed_array[1];
	
		// Make the query:
		$q = "SELECT * FROM history WHERE LotName='$ln' AND 
			  User='$un' AND StartTime >= '$sd' AND StartTime <= '$ed'";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			$totalDays = 0;
			$totalTimeMinutes = 0;

			while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$totalDays++;
				$qq = "SELECT * FROM history WHERE LotName='$ln' AND User='$un' AND 
					   StartTime='".$row['StartTime']."' AND EndTime='".$row['EndTime']."'";
				$rr = @mysqli_query ($dbc, $qq);

				if ($rr){
					while ($row1=mysqli_fetch_array($rr, MYSQLI_ASSOC)) {
						$row1_st = explode(" ", $row1['StartTime']);
						$startTimeArray = explode(":", $row1_st[1]);
						$row1_et = explode(" ", $row1['EndTime']);
						$endTimeArray = explode(":", $row1_et[1]);

						if ($startTimeArray[0] != $endTimeArray[0]) {
							$totalTimeMinutes += (intval($endTimeArray[0]) - intval($startTimeArray[0])) * 60;
							
							if ($startTimeArray[1] != 0) {
								$totalTimeMinutes += 60 - intval($startTimeArray[1]);
							}

							$totalTimeMinutes += intval($endTimeArray[1]);

						} else {
							$totalTimeMinutes += intval($endTimeArray[1]) - intval($startTimeArray[1]);
						}
						
					}
				}
			}

			echo   '<table id="report">
						<tr>
							<td id="reportname" colspan="2">'.$ln.' Usage For '.$un.'</td>
						</tr>
						<tr>
							<th>Times Used</th>
							<td id="reportnumber">'.$totalDays.'</td>
						</tr>
						<tr>
							<th>Total Time</th>
							<td id="reportnumber">'.(intval($totalTimeMinutes / 60)).' hour(s) and '.($totalTimeMinutes % 60).' minutes</td>
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

include ('includes/footer.html');
?>