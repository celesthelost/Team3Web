/* 	validateLoginForm()
	Added by Timothy Lester on 2015-09-19
	- Validates that the each of the login form's fields has a value. If a field is
	left blank, the color of the field is changed to a light red.
*/
function validateLoginForm(){
	var alertMsg = "Please correct the following items:\n";
	var uname = document.getElementsByName('uname')[0].value; 
	var pword = document.getElementsByName('pword')[0].value;
	
	if (uname != "" && pword != "")
	{
		document.getElementsByName('uname')[0].style.background = "#FFF";
		document.getElementsByName('pword')[0].style.background = "#FFF";
		return true;
	}
		
	if (uname === "")
	{
		alertMsg += "Username\n";
		document.getElementsByName('uname')[0].style.background = "#FF5050";
	}
	else
		document.getElementsByName('uname')[0].style.background = "#FFF";
	
	if (pword === "")
	{
		alertMsg += "Password\n";
		document.getElementsByName('pword')[0].style.background = "#FF5050";
	}
	else
		document.getElementsByName('pword')[0].style.background = "#FFF";
	
	alert(alertMsg);
	return false;
}