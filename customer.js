/*
	Author: Sonali Chauhan
	Date: 19/05/2020
	Description: Customer file is used to check validation for login.
*/
var xhr = false;
if (window.XMLHttpRequest) {
	xhr = new XMLHttpRequest();
}
else if (window.ActiveXObject) {
	xhr = new ActiveXObject("Microsoft.XMLHTTP");
}


// access user inputs from customer page and pass them
function testLogin() {
	
	var email = document.getElementById('email').value;
	var password = document.getElementById('password').value;

	// Get method is used to send data to php file which will save values to xml file.
	//&lastname is variable in php file and lastname is variable that we take from user.
	xhr.open("GET", "login.php?email=" + email + "&password=" +password+ 
		"&id=" + Number(new Date), true);

	xhr.onreadystatechange = testInput;
	xhr.send(null);
	
}

function testInput() 
{
	
	if ((xhr.readyState == 4) && (xhr.status == 200)) {
		document.getElementById('msg').innerHTML = xhr.responseText;
	}
	
}




