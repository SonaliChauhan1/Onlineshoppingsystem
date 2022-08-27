/*
	Author: Sonali Chauhan
	Date: 19/05/2020
	Description: processing file to get and send data to/from xml.
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

setInterval(function() 
{
	xmlDoc=loadXMLDoc("data/goods.xml");
}, 5000);

//setInterval(getData,10000);
setInterval("displayItems();",10000);

var url = "data/goods.xml";
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
	xhttp.open("GET",url,false);
	xhttp.send();
	return xhttp.responseXML;
}


function displayItems() 
{
  xmlDoc=loadXMLDoc("data/goods.xml");
  
  var goods = xmlDoc.getElementsByTagName("Item");
  
  var div = document.getElementById("mainContent");
  div.innerHTML = "<table border='1'>";
  div.innerHTML += "<table border='1'><tr><th>Item Number</th><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th><th>On Hold</th><th>Sold</th></tr>";
  for (i=0; i<goods.length; i++) 
  {
    var ItemNumber = goods[i].getElementsByTagName("ItemNumber")[0].childNodes[0].nodeValue;
    var ItemName = goods[i].getElementsByTagName("ItemName")[0].childNodes[0].nodeValue;
    var ItemDescription = goods[i].getElementsByTagName("ItemDescription")[0].childNodes[0].nodeValue;
    var ItemPrice = goods[i].getElementsByTagName("ItemPrice")[0].childNodes[0].nodeValue;
    var ItemQuantity = goods[i].getElementsByTagName("ItemQuantity")[0].childNodes[0].nodeValue;
    var ItemHold = goods[i].getElementsByTagName("OnHold")[0].childNodes[0].nodeValue;
    var ItemSold = goods[i].getElementsByTagName("Sold")[0].childNodes[0].nodeValue;

    div.innerHTML+="<table border='1'><tr><td id=\"itemnumber"+i+"\">"+ItemNumber +"</td><td id=\"itemname"+i+"\">"+
    ItemName +"</td></td><td id=\"itemdescription"+i+"\">"+ItemDescription +
    "</td><td id=\"itemprice"+i+"\">"+ItemPrice +"</td><td id=\"itemquantity"+i+"\">"+ItemQuantity +
    "</td><td>"+ItemHold+"</td><td>"+ItemSold+"</td></tr>";
    
  
    }
	div.innerHTML += "<tr><td colspan='7'><button onclick=''>Process</button></td></tr>";
   div.innerHTML += "</table>";
}