/*
	Author: Sonali Chauhan
	Date: 19/05/2020
	Description: register file to send and get data from php and xml.
*/
var xhr = false;
if (window.XMLHttpRequest) {
	xhr = new XMLHttpRequest();
}
else if (window.ActiveXObject) {
	xhr = new ActiveXObject("Microsoft.XMLHTTP");
}


// access user inputs from customer page and pass them
// to custRegister.php
function testGet() 
{
	
	var firstname = document.getElementById('firstname').value;
	var lastname = document.getElementById('lastname').value;
	var email = document.getElementById('email').value;
	var password = document.getElementById('password').value;
	var confirmpassword = document.getElementById('confirmpassword').value;
	var contact = document.getElementById('contact').value;

	// Get method is used to send data to php file which will save values to xml file.
	//&lastname is variable in php file and lastname is variable that we take from user.
	xhr.open("GET", "register.php?firstname=" + firstname + "&lastname=" + lastname 
		+ "&email=" + encodeURIComponent(email) + "&password=" + encodeURIComponent(password) + "&confirmpassword=" 
		+confirmpassword+	"&contact=" + contact +	"&cusid=" + Number(new Date), true);

	xhr.onreadystatechange = testInput;
	xhr.send(null);
	
}

function testInput() 
{
	
	if ((xhr.readyState == 4) && (xhr.status == 200)) 
	{
		document.getElementById('msg').innerHTML = xhr.responseText;
	}
	
}




