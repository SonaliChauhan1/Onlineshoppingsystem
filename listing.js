/*
	Author: Sonali Chauhan
	Date: 19/05/2020
	Description: listing file to get and send data to/from php.
*/
var xhr = false;
if (window.XMLHttpRequest) 
{
	xhr = new XMLHttpRequest();
}
else if (window.ActiveXObject) 
{
	xhr = new ActiveXObject("Microsoft.XMLHTTP");
}


function addItem() {
	
	var itemname = document.getElementById('itemname').value;
	var itemprice = document.getElementById('itemprice').value;
	var itemquantity = document.getElementById('itemquantity').value;
	var itemdescription = document.getElementById('itemdescription').value;

	// Get method is used to send data to php file which will save values to xml file.
	
	xhr.open("GET", "listing.php?itemname=" + itemname + "&itemprice=" + itemprice 
		+ "&itemquantity=" + itemquantity + "&itemdescription=" +itemdescription 
		+	"&id=" + Number(new Date), true);

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

function resetForm() 
{
	document.getElementById("itemname").value ="";
	document.getElementById('itemprice').value="";
	document.getElementById('itemquantity').value="";
	document.getElementById('itemdescription').value ="";
}



