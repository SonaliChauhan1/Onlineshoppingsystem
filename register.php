<?php
/*
	Author: Sonali Chauhan
	Date: 19/05/2020
	Description: Register file to store valeus in xml.
*/
session_start();

header('Content-Type: text/xml');

if(isset($_GET["firstname"]) && isset($_GET["lastname"]) && isset($_GET["email"]) && 
	isset($_GET["password"]) && isset($_GET["confirmpassword"]) && isset($_GET["contact"]))
{

	$firstname = $_GET["firstname"];
	$lastname = $_GET['lastname'];
	$email = $_GET["email"];
	//echo $_GET["confirmpassword"]; die;
	$password = md5($_GET["password"]);
	$confirmpassword = md5($_GET["confirmpassword"]);
	$contact = $_GET['contact'];
	$contactnumberRegex = preg_match("/^(\(0[0-9]{1}\)\s*|0[0-9]{1}\ )[0-9]{8}$/", $contact);
	$emailRegex = preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $email);
	//$customerid = $_GET['cusid'];
	$customerid = rand(100, 3000);
	$errMsg = "";
	if (empty($_GET["firstname"]) OR !preg_match('/^[a-zA-Z\s]*$/', $firstname)) {
			$errMsg .= "Please enter your first name correct. <br />";
	}
	if (empty($_GET['lastname']) OR !preg_match('/^[a-zA-Z\s]*$/', $lastname)) {
			$errMsg .= "Please enter your last name correct. <br />";
	}
	if (empty($_GET["email"])) {
			$errMsg .= "You must enter an email id. <br />";

	}
	if (empty($_GET["password"])) {
			$errMsg .= "You must enter a password. <br />";
	}
	if ( empty($_GET["confirmpassword"])) 
	{
			$errMsg .= "You must enter your confirm password. <br />";
	}
	if ($password != $confirmpassword) 
	{
			$errMsg.= "Your password's are not matching. <br/>";
	}
	if (!$emailRegex) 
	{
		# code...
			$errMsg.= "please enter email in valid format <br/>";
	}
	if (!empty($_GET['contact']) && !$contactnumberRegex) {
		# code...
		$errMsg .= "Please enter the number in format of 0d dddddddd.";
	}
	if ($errMsg != "") 
	{
			echo $errMsg;
	}
	else 
	{
	
		$xmlfile = 'data/customer.xml';
		$doc = new DomDocument();
		
		if (!file_exists($xmlfile))
		{ // if the xml file does not exist, create a root node $customers
			$customers = $doc->createElement('customers');
			$doc->appendChild($customers);

			$customer = $doc->createElement('customer');
			$customers->appendChild($customer);
			
			$tag = $doc->createElement("customerid",$customerid);
			$customer->appendChild($tag);

			$tag1 = $doc->createElement("firstname",$firstname);
			$customer->appendChild($tag1);

			$tag2 = $doc->createElement("lastname",$lastname);
			$customer->appendChild($tag2);

			$tag3 = $doc->createElement("email",$email);
			$customer->appendChild($tag3);

			$tag4 = $doc->createElement("password",$password);
			$customer->appendChild($tag4);

			// $tag5 = $doc->createElement("confirmpassword",$confirmpassword);
			// $customer->appendChild($tag5);

			$tag6 = $doc->createElement("contact",$contact);
			$customer->appendChild($tag6);
	
			//save the xml file
			$doc->formatOutput = true;
			$doc->save($xmlfile);  
			echo "Thank you for registering with Buy Online....!";
			echo("<br/><table><tr><td><button onclick=\"location.href='buyonline.htm'\">BuyOnline</button></td></table>");
		}
		else 
		{ 
			// load the xml file
			//$doc->preserveWhiteSpace = FALSE;
			$doc = file_get_contents('data/customer.xml');
			if (strpos($doc, "<email>$email</email>") !== false) 
			{
			# you found matching email...
				die("You have an email id with same mail address.");
				//header("Location:register.html");
			}
			else
			{
				$doc = new DomDocument("1.0","UTF-8");
				$doc->load("data/customer.xml");
				$customers = $doc->getElementsByTagName('customers')->item(0);
				$customer = $doc->createElement('customer');
				$customers->appendChild($customer);
				
				$tag = $doc->createElement("customerid",$customerid);
				$customer->appendChild($tag);

				$tag1 = $doc->createElement("firstname",$firstname);
				$customer->appendChild($tag1);

				$tag2 = $doc->createElement("lastname",$lastname);
				$customer->appendChild($tag2);

				$tag3 = $doc->createElement("email",$email);
				$customer->appendChild($tag3);

				$tag4 = $doc->createElement("password",$password);
				$customer->appendChild($tag4);

				// $tag5 = $doc->createElement("confirmpassword",$confirmpassword);
				// $customer->appendChild($tag5);

				$tag6 = $doc->createElement("contact",$contact);
				$customer->appendChild($tag6);
				
				//save the xml file
				$doc->formatOutput = true;
				$doc->save($xmlfile);  
				echo "Thank you for registering with Buy Online....!";
				echo("<br/><table><tr><td><button onclick=\"location.href='buyonline.htm'\">BuyOnline</button></td></table>");
			} 
		
		}
	} 
}

?>