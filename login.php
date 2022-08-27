<?php
/*
	Name: Sonali Dilip Chauhan
	Student ID: 102836414
	Description: The customer can login.
 */ 
	session_start();
	error_reporting(E_ALL); 
	ini_set("display_errors", 1);

	if(isset($_GET["email"]) && isset($_GET["password"]))
	{
		//$managerid = $_GET['id'];
		$email = $_GET["email"];
		//echo $_GET["email"];die;
		//echo $_GET["password"];die;
		$password = md5($_GET['password']);
		$emailRegex = preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $email);

		$_SESSION['email'] = $email;
		
		$errMsg = "";

		if (empty($_GET["email"])) {
				$errMsg .= "Please enter your email address. <br />";
		}

		if (empty($_GET["password"])) {
				$errMsg .= "Please enter your password. <br />";
		}
		if (!$emailRegex) 
		{
			# code...
				$errMsg.= "please enter email in valid format <br/>";
		}
		if ($errMsg != "") 
		{
				echo $errMsg;
		}
		else
		{
			$xmlfile = "data/customer.xml";

			if (!file_exists($xmlfile)) 
			{
				# code...
				echo "No customer file found";
			}
			else
			{
				$xml=simplexml_load_file($xmlfile) or die("Error: Cannot create object");
				// Loop over the Entity nodes:
				$flag = false;
				foreach ($xml->customer as $e) 
				{
					(string)$e->password;
				    (string)$e->firstname."<br/>";
				    (string)$e->email."<br/>";
				    (string)$e->customerid ."<br/>";
					
					if ($email == (String)$e->email && md5($_GET["password"]) == (string)$e->password ) 
					{
					# code...
						//echo "email found<br/>"; die;

						$e->email;
						$e->firstname;
						$e->lastname;
						$e->contact;
						$pass = $e->email;
						$cusid = $e->customerid;
						$e->password;
						$_SESSION['email'] = (String)$pass;
						$_SESSION['customerid'] = (String)$cusid;
						echo "Loading........";
						echo "<meta http-equiv='refresh' content='2;url=buying.htm'>";
						$flag = true;
						// header('Location: buying.htm');
						exit;

					}
				}
				if($flag == false)
				{
					echo "Wrong email id or password";
				}
			}

		}
	}			
?>