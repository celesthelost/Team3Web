<?php # Script 12.1 - login_page.inc.php
// This page prints any errors associated with logging in
// and it creates the entire login page, including the form.

// Include the header:
$page_title = 'Login';
include ('includes/header.html');
echo '<h1>Login</h1>';
// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	echo '<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
}

// Display the form:
?>
<form action="login.php" method="post">
	<table id="subForm">
		<tr>
			<td>Username:</td>
			<td><input type="text" name="email" size="20" maxlength="60" /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input id="passwordField" type="password" name="pass" size="20" maxlength="20" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input id="submitButton" type="submit" name="submit" value="Login" /></td>
		</tr>
	</table>
</form>
<?php include ('includes/footer.html'); ?>