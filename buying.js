/*

	Name: Sonali Dilip Chauhan
	Student ID: 102836414
	Description: The buying file to perform cart functionality.
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
// to load the goods.xml file every 5 secs.
setInterval(function() 
{
	xmlDoc=loadXMLDoc("data/goods.xml");
}, 5000);
//to load the table every 10 secs on html.
setInterval("displayItems();",10000);

// gets data from php and displays the table on frontend.
function getData()
{   
  if ((xhr.readyState == 4) &&(xhr.status == 200))
    { 
    	alert(xhr.responseText);
    	var serverResponse = xhr.responseXML;		
		alert(serverResponse);
		var header = serverResponse.getElementsByTagName("item");
		var spantag = document.getElementById("cart");
		var x;
    
		spantag.innerHTML = "";  
		var granTotal = 0;
		x = "<br/><p>Shopping Cart</p><table border='1'>";
		x += "<tr><td>Item Number</td><td>Price</td><td>Quantity</td><td>Total</td><td>Remove</td></tr>";
        for (i=0; i<header.length; i++)
        {  
			var id =  header[i].getElementsByTagName("id")[0].childNodes[0].nodeValue;
			var total =  header[i].getElementsByTagName("total")[0].childNodes[0].nodeValue;
			var number =  header[i].getElementsByTagName("itemnumber")[0].childNodes[0].nodeValue;
			var price =  header[i].getElementsByTagName("price")[0].childNodes[0].nodeValue;
			var qty =  header[i].getElementsByTagName("quantity")[0].childNodes[0].nodeValue;
			 
			granTotal += parseInt(total);
			if(qty=="0")
			{
				continue;
			}
			x += "<tr>"
			+ "<td>" + number + "</td>"
			+ "<td>" + price + "</td>"
			+ "<td>" + qty + "</td>"
			+ "<td>" + total + "</td>"
			+ "<td>" + "<button onclick='AddRemoveItem(\"Remove\","+id+");'>Remove Item</button>" + "</td>"
			+ "</tr>"; 
			   
        }
		
		x += "<tr>"
		+"<td colspan='4'> Total :</td>"
		+ "<td>" + granTotal + "</td>"
		+ "</tr>"
		+"<tr>"
		+"<td colspan='5'> <button onclick='AddRemoveItem(\"Confirm\","+id+");'>Confirm purchase</button>&nbsp&nbsp&nbsp&nbsp&nbsp<button onclick='AddRemoveItem(\"Cancel\","+id+");'>Cancel purchase</button></td>"
		+ "</tr>"
		+"</table>";
		if (header.length != 0)
			spantag.innerHTML = x;
	}
}

function loadXMLDoc(dname)
{
	if (window.XMLHttpRequest)
	{
		xhttp=new XMLHttpRequest();
	}
	else
	{
		xhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhttp.open("GET","data/goods.xml",false);
	xhttp.send();
	return xhttp.responseXML;
}

// to display details on frontend.
function displayItems() 
{
	xmlDoc=loadXMLDoc("data/goods.xml");
  	
	var goods = xmlDoc.getElementsByTagName("Item");
  
	var div = document.getElementById("mainContent");
	div.innerHTML = "<table border='1'>";
	div.innerHTML += "<table border='1'><tr><th>Item Number</th><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th><th>Add</th></tr>";
	for (i=0; i<goods.length; i++) 
	{
		var ItemNumber = goods[i].getElementsByTagName("ItemNumber")[0].childNodes[0].nodeValue;
		var ItemName = goods[i].getElementsByTagName("ItemName")[0].childNodes[0].nodeValue;
		var ItemDescription = goods[i].getElementsByTagName("ItemDescription")[0].childNodes[0].nodeValue;
		var ItemPrice = goods[i].getElementsByTagName("ItemPrice")[0].childNodes[0].nodeValue;
		var ItemQuantity = goods[i].getElementsByTagName("ItemQuantity")[0].childNodes[0].nodeValue;

		div.innerHTML+="<table border='1'><tr><td id=\"itemnumber"+i+"\">"+ItemNumber +"</td><td id=\"itemname"+i+"\">"+
		ItemName +"</td></td><td id=\"itemdescription"+i+"\">"+ItemDescription.substring(0,20) +
		"</td><td id=\"itemprice"+i+"\">"+ItemPrice +"</td><td id=\"itemquantity"+i+"\">"+ItemQuantity +
		"</td><td><button onClick=\"AddRemoveItem('Add',"+i+");\" >Add to Shopping Cart</button></td></tr>";
		
	  
	}
	div.innerHTML += "</table>";
}

// function to add, remove and get id to pass to php.
function AddRemoveItem(action,id)
{   
	var itemnumber = document.getElementById("itemnumber"+id).innerHTML; 
	var itemname = document.getElementById("itemname"+id).innerHTML; 
	var price = document.getElementById("itemprice"+id).innerHTML;
  
	
	xhr.open("GET", "buying.php?action=" + action + "&itemnumber=" +  
		encodeURIComponent(itemnumber) + "&price=" + price + "&itemname=" + itemname+"&id="+id, true);
	
	xhr.onreadystatechange = getData;
	xhr.send(null);   
}