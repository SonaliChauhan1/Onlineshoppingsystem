/*
	Author: Sonali Chauhan
	Date: 19/05/2020
	Description: 
*/
var xhr = false;
if (window.XMLHttpRequest) {
	xhr = new XMLHttpRequest();
}
else if (window.ActiveXObject) {
	xhr = new ActiveXObject("Microsoft.XMLHTTP");
}


// access user inputs from page and pass them

function testGet() {
	
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;

	// Get method is used to send data to php file which will save values to xml file.
	
	xhr.open("GET", "mlogin.php?username=" + username + "&password=" +password+ 
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




