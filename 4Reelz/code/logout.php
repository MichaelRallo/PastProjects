<!-- https://babbage.cs.missouri.edu/~cs3380s15grp7/imdb/index.php -->
<?php
	session_start();

	//Check if using secured https
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $redirect");
	}
	
	//Check if a user is logged in
	if(isset($_SESSION['username']))
	{	
		//Connect To Database
		include("../secure/database.php");
		$dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());
		if(!$dbconn) 
		{
			echo "<p>Failed to connect to DB</p>\n";
		}	
				
		$username = $_SESSION['username'];
		$timestamp = date('Y-m-d G:i:s');
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$action = "Logout";
			
		//Update Activity Log
		$sql = "INSERT INTO userTables.log(username, ip_address, log_date, action) VALUES ($1, $2, $3, $4)";
		pg_prepare($dbconn, 'my_query9', $sql);
		pg_execute($dbconn, 'my_query9', array($username, $ip_address, $timestamp, $action)) or die("<br /> Error while inserting.");

		pg_close($dbconn);
		unset($_SESSION['username']);
		header('Location: index.php');
	}
	else
	{
		header('Location: index.php');
	}
?>

