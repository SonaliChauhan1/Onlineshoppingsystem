<?php
/*
	Name: Sonali Dilip Chauhan
	Student ID: 102836414
	Description: The buying file to perform cart functionality.
 */
session_start();
if (!$_SESSION['email'] && !$_SESSION['customerid']) 
{
	header("Location : login.html");	
}

header('Content-Type: text/xml');

	//$_SESSION['customerid'];
	//$_SESSION['email'];
 $itemnumber =$_GET['itemnumber'];
 $itemname = $_GET['itemname'];
 $price = $_GET['price'];
 $id = $_GET['id'];
 $action = $_GET['action'];
 $customerid = $_SESSION['customerid'];

$xmlfile = "data/goods.xml";

if (!file_exists($xmlfile)) 
{
	echo "No goods file found";
}
else
{
	
	$itemname = $_GET['itemname'];
	$xmlfile = "data/goods.xml";
	$xml=simplexml_load_file($xmlfile) or die("Error: Cannot create object");// to load xml file and get contents
	$nameFlag = false;
	$qtyFlag = false;

	
	if (!(empty($_SESSION["cart"])))
	{
		$cart = $_SESSION["cart"];
		
		if ($action == "Add")
		{
			if (!isset($cart[$itemname]))//if cart is not empty.
			{
				//store details in xml file
				foreach ($xml->Item as $e)
				{
					//$i+=1;
					(string)$e->ItemName; 
					(string)$e->ItemQuantity;
					(string)$e->OnHold;
					if($itemname == (string)$e->ItemName)
					{
						$nameFlag = true;
						if((string)$e->ItemQuantity > 0)
						{
							(string)$e->ItemQuantity -= 1;
							(string)$e->OnHold += 1;
							$qtyFlag = true;
						}
					}
				}
				if($nameFlag == false)
				{
					echo "No such item present in the cart"; die;
				}
				if($qtyFlag == false)
				{
					echo "Sorry, this item is not available for sale"; die;
				}
				file_put_contents("data/goods.xml",$xml->saveXML());
				//update tempory cart xml file toXml() mentioned below.
				$qty = 1;
				$value = array();
				$value["qty"] = $qty;
				$value['itemnumber'] = $itemnumber;
				$value["total"] = $price;
				$value["price"] = $price;
				$value["id"] = $id;
				$cart[$itemname] = $value;
				$value["id"] = $id;
				$_SESSION["cart"] = $cart; // save the adjusted cart to session variable 
				echo (toXml($cart));
			}
			else // if first item in the cart
			{
				foreach ($xml->Item as $e)
				{
					//$i+=1;
					(string)$e->ItemName; 
					(string)$e->ItemQuantity;
					(string)$e->OnHold;
					if($itemname == (string)$e->ItemName)
					{
						$nameFlag = true;
						if((string)$e->ItemQuantity > 0)
						{
							(string)$e->ItemQuantity -= 1;
							(string)$e->OnHold += 1;
							$qtyFlag = true;
						}
					}
				}
				if($nameFlag == false)
				{
					echo "No such item present in the cart"; die;
				}
				if($qtyFlag == false)
				{
					echo "Sorry, this item is not available for sale"; die;
				}
				file_put_contents("data/goods.xml",$xml->saveXML());
				//update tempory cart xml file toXml() mentioned below.
				$value = $cart[$itemname];
				$value["id"] = $id;
				$value["qty"] += 1;
				$value["price"] = $price;
				$value["total"] = $value["price"] * $value["qty"];
				$cart[$itemname] = $value;
				$_SESSION["cart"] = $cart;
				echo (toXml($cart));
			}
		}
		else if($action == "Remove")// to remove a item from cart.
		{
			//update tempory cart xml file toXml() mentioned below.
			$value = $cart[$itemname];
			$value["qty"] -= 1;
			$value["id"] = $id;
			$value["price"] = $price;
			$value["total"] = $value["price"] * $value["qty"];
			$cart[$itemname] = $value;
			$_SESSION["cart"] = $cart;
			echo(toXml($cart));
			// update cart in goods.xml
			foreach ($xml->Item as $e)
			{
				//$i+=1;
				(string)$e->ItemName; 
				(string)$e->ItemQuantity;
				(string)$e->OnHold;
				if($itemname == (string)$e->ItemName)
				{
					$nameFlag = true;
					
					(string)$e->OnHold = (string)$e->OnHold - 1;
					(string)$e->ItemQuantity = (string)$e->ItemQuantity + 1;
					//(String)$e->Sold += 1;
					//$qtyFlag = true;
				
				}
			}
			if($nameFlag == false)
			{
				echo "No such item present in the cart"; die;
			}
			file_put_contents("data/goods.xml",$xml->saveXML());
		}
		elseif($action == "Confirm")
		{	
			echo "Sorry the cart functionality is not working right now.";
		}
		elseif($action == "Remove")
		{
			echo "Sorry cancel functionality is nor working right now.";
		}
	}
	elseif ($action == "Add") 
	{ //if cart is not set the set the cart.
		foreach ($xml->Item as $e)
		{
			//$i+=1;
			(string)$e->ItemName; 
			(string)$e->ItemQuantity;
			(string)$e->OnHold;
			if($itemname == (string)$e->ItemName)
			{
				$nameFlag = true;
				if((string)$e->ItemQuantity > 0)
				{
					(string)$e->ItemQuantity -= 1;
					(string)$e->OnHold += 1;
					$qtyFlag = true;
				}
			}
		}
		if($nameFlag == false)
		{
			echo "No such item present in the cart"; die;
		}
		if($qtyFlag == false)
		{
			echo "Sorry, this item is not available for sale"; die;
		}
		file_put_contents("data/goods.xml",$xml->saveXML());
		//update tempory cart xml file toXml() mentioned below.
		$value = array();
		$value["qty"] = "1";
		//$ItemQuantity -= $value["qty"];
		$value["price"] = $price;
		$value["id"] = $id;
		$value["total"] = $value["price"];
		$value["itemnumber"] = $itemnumber;
		$cart = array();
		$cart[$itemname] = $value;
		$_SESSION["cart"] = $cart;
		echo (toXml($cart));
	}
	
}

//temporary cart.
function toXml($shop_cart)
{
	$doc = new DomDocument('1.0');
	$cart = $doc->createElement('cart');
	$cart = $doc->appendChild($cart);
		
	foreach ($shop_cart as $Item => $ItemName)
	{ 
		//to create <item></item>
		$item = $doc->createElement("item");
		$cart->appendChild($item);
			
        $itemname = $doc->createElement('itemname'); 
        $item->appendChild($itemname);
        $value = $doc->createTextNode($Item);
        $itemname->appendChild($value);
			
		$itemnumber = $doc->createElement('itemnumber');
        $item->appendChild($itemnumber);
        $value2 = $doc->createTextNode($ItemName["itemnumber"]);
        $itemnumber->appendChild($value2);
			
		$itemprice = $doc->createElement('price');
        $item->appendChild($itemprice);
        $value2 = $doc->createTextNode($ItemName["price"]);
        $itemprice->appendChild($value2);
			
			
		$quantity = $doc->createElement('quantity');
        $item->appendChild($quantity);
        $value4 = $doc->createTextNode($ItemName["qty"]);
        $quantity->appendChild($value4);
			
		$total = $doc->createElement('total');
        $item->appendChild($total);
        $value5 = $doc->createTextNode($ItemName["total"]);
        $total->appendChild($value5);
			
		$id = $doc->createElement('id');
        $item->appendChild($id);
        $value6 = $doc->createTextNode($ItemName["id"]);
        $id->appendChild($value6);
			
    }
    $strXml = $doc->saveXML();
    return $strXml;
}

?>





