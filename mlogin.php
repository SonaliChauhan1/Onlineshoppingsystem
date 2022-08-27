<?php
/*

	Name: Sonali Dilip Chauhan
	Student ID: 102836414
	Description: The manager can login.
 */ 
	session_start();
	error_reporting(E_ALL); 
	ini_set("display_errors", 1);

	if(isset($_GET["username"]) && 	isset($_GET["password"]))
	{
		//$managerid = $_GET['id'];
		$username = $_GET["username"];
		$password = $_GET['password'];
		$_SESSION['managerid'] = $username;
		$errMsg = "";
		if (empty($username) OR !preg_match('/^[a-zA-Z]*$/', $username)) {
				$errMsg .= "Manager Please enter your correct username. <br />";
		}

		if (empty($password)) {
				$errMsg .= "Manager You must enter a password. <br />";
		}
		
		if ($errMsg != "") {
				echo $errMsg;
		}
		else
		{
			$exist = false;                                        
			$file = fopen("data/manager.txt", "r") or die("Unable to open file!");
	
			while(!feof($file)) 
			{
				$str = fgets($file);
				$st = (explode(',',$str,2));
				if(!(strcasecmp($username,$st[0]) OR strcmp($password,trim($st[1])))) 
				{
					$exist = true;
				}
			}
			fclose($file);
			if($exist) 
			{
				$_SESSION["managerid"] = $username;
				echo $message = '<br/>Welcome ' . $username.', work hard!! <br/>';
				//header('Location: login.htm');
				echo("<br/><table><tr><td><button onclick=\"location.href='listing.htm'\">Listing</button></td>");
				echo("<td><button onclick=\"location.href='processing.htm'\">Processing</button></td></tr></table>");
			} 
			else 
			{
				echo "Wrong Id or Password";
			}
		}

	}
?>