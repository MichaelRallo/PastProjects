<?php
session_start();
	
	
	//Check if a user is logged in
	if(isset($_SESSION['username']))
	{	
		unset($_SESSION['username']);
		header('Location: ../index.php');
	}
	else
	{
		header('Location: ../index.php');
	}
?>


