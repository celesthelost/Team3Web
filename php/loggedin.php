<?php # Script 12.9 - loggedin.php #2
// The user is redirected here from login.php.

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('includes/login_functions.inc.php');
	redirect_user();	

}

// Set the page title and include the HTML header:
header('Refresh: 5; URL=index.php');
$page_title = 'Logged In!';
include ('includes/header.html');

// Print a customized message:
echo "<h1>Logged In!</h1>
<p>You are now logged in, {$_SESSION['first_name']} {$_SESSION['last_name']}!</p>
<p>You are being redirected to the portal home page.</p>";

include ('includes/footer.html');
?>