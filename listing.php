<?php
/*
	Author: Sonali Chauhan
	Date: 20/05/2020
	Description: Listing file is used to create xml to store values to goods.xml.
*/
session_start();
error_reporting(E_ALL); 
ini_set("display_errors", 1);

if (!isset($_SESSION['managerid'])) 
{
	header("Location: mlogin.php");
}

if (isset($_GET['itemname']) && isset($_GET['itemprice']) && isset($_GET['itemquantity']) && isset($_GET['itemdescription'])) 
{
	# code...
	
	$itemname = $_GET['itemname'];
	$itemprice = $_GET['itemprice'];
	$itemquantity = $_GET['itemquantity'];
	$itemdescription = $_GET['itemdescription'];
	$itemnumber = rand();
	$onhold = 0;
	$sold =0;
	$errMsg = "";

	if (empty($_GET['itemname']) OR !preg_match('/^[a-zA-Z0-9\s]*$/', $itemname)) 
	{
		# code...
		$errMsg .= "Please enter item name and must input a name.<br />";
	}

	if (empty($_GET['itemprice']) OR !preg_match('/^[0-9]*$/', $itemprice)) 
	{
		# code...
		$errMsg .= "Please enter item price.<br />";
	}

	if (empty($_GET['itemquantity']) OR !preg_match('/^[0-9]*$/', $itemquantity)) 
	{
		# code...
		$errMsg .= "Please enter item quantity.<br />";
	}

	if (empty($_GET['itemdescription'])) 
	{
		# code...
		$errMsg .= "Please enter item description.<br />";
	}
	if ($errMsg != "") 
	{
		# code...
		echo $errMsg;
	}
	else
	{
		//echo "yaay";
		$xmlfile = 'data/goods.xml';
		$doc = new DomDocument();
		
		if (!file_exists($xmlfile))// find file.
		{ 
	
			$goods = $doc->createElement('Goods');
			$doc->appendChild($goods);

			$item = $doc->createElement('Item');
			$goods->appendChild($item);
			
			$tag = $doc->createElement("ItemNumber",$itemnumber);
			$item->appendChild($tag);

			$tag1 = $doc->createElement("ItemName",$itemname);
			$item->appendChild($tag1);

			$tag2 = $doc->createElement("ItemDescription",$itemdescription);
			$item->appendChild($tag2);
			
			$tag3 = $doc->createElement("ItemPrice",$itemprice);
			$item->appendChild($tag3);

			$tag4 = $doc->createElement("ItemQuantity",$itemquantity);
			$item->appendChild($tag4);

			$tag5 = $doc->createElement("OnHold",$onhold);
			$item->appendChild($tag5);

			$tag6 = $doc->createElement("Sold",$sold);
			$item->appendChild($tag6);

			//save the xml file
			$doc->formatOutput = true;
			$doc->save($xmlfile);  
			echo "The item has been listed in the system, and the item number is:". $itemnumber;
		}
		else 
		{ 
			// load the xml file
			//$doc->preserveWhiteSpace = FALSE;
			$doc = file_get_contents('data/goods.xml');
			$doc = new DomDocument("1.0","UTF-8");
			$doc->load("data/goods.xml");
			$goods = $doc->getElementsByTagName('Goods')->item(0);

			$item = $doc->createElement('Item');
			$goods->appendChild($item);
			
			$tag = $doc->createElement("ItemNumber",$itemnumber);
			$item->appendChild($tag);

			$tag1 = $doc->createElement("ItemName",$itemname);
			$item->appendChild($tag1);

			$tag2 = $doc->createElement("ItemDescription",$itemdescription);
			$item->appendChild($tag2);

			$tag3 = $doc->createElement("ItemPrice",$itemprice);
			$item->appendChild($tag3);

			$tag4 = $doc->createElement("ItemQuantity",$itemquantity);
			$item->appendChild($tag4);

			$tag5 = $doc->createElement("OnHold",$onhold);
			$item->appendChild($tag5);

			$tag6 = $doc->createElement("Sold",$sold);
			$item->appendChild($tag6);

			//save the xml file
			$doc->formatOutput = true;
			$doc->save($xmlfile);  
			echo "The item has been listed in the system, and the item number is:". $itemnumber;
			
		
		}
	}
}
?>