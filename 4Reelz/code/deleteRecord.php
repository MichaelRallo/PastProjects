<!-- Michael Rallo msr5zb 12358133 -->
<!DOCTYPE html>
<html>
<head>
<meta charset=UTF-8>
<title>CS 3380 Lab 5 Delete Page</title>
</head>
<body>

<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">

<?php

	//Grab Keys from Index
	$table = $_SESSION['table'];
	$id = $_POST['id'];

	//Connect To Database
	include("secure/database.php");
	$dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());
	if(!$dbconn) 
	{
		echo "<p>Failed to connect to DB</p>";
	}
	
	//Find Desired Delete Option
	switch($table)								
	{
		case movie: 	
				
				//Perform DELETE
				$sql = "DELETE FROM fourreelz.movie WHERE id = $1;";
				$result = pg_prepare($dbconn, 'my_query', $sql);
				$result = pg_execute($dbconn, 'my_query', array($id));

				//If delete was successful
				if ($result = TRUE)
				{
					echo"Delete was successful<br />\n";
					echo"Return to <a href='index.php'>search page</a>\n";
				} 
				
				//If delete failed
				else 
				{
					echo "Error deleting record: \n";
					echo"Return to <a href='index.php'>search page</a>\n";
				}
					
				break;	
					
		case actor: 
			
				//Perform DELETE
				$sql = "DELETE FROM fourreelz.actor WHERE id = $1;";
				$result = pg_prepare($dbconn, 'my_query', $sql);
				$result = pg_execute($dbconn, 'my_query', array($id));	

				//If delete was successful
				if ($result = TRUE)
				{
					echo"Delete was successful<br />\n";
					echo"Return to <a href='index.php'>search page</a>\n";
				} 
				
				//If delete failed
				else 
				{
					echo "Error deleting record: \n";
					echo"Return to <a href='index.php'>search page</a>\n";
				}
				
				break;	
								
		case directors:
		
				//Perform DELETE
				$sql = "DELETE FROM fourreelz.directors WHERE (id = $1);";
				$result = pg_prepare($dbconn, 'my_query', $sql);
				$result = pg_execute($dbconn, 'my_query', array($id));	

				//If delete was successful
				if ($result = TRUE)
				{
					echo"Delete was successful<br />\n";
					echo"Return to <a href='index.php'>search page</a>\n";
				} 
				
				//If delete failed
				else 
				{
					echo "Error deleting record: \n";
					echo"Return to <a href='index.php'>search page</a>\n";
				}
				
				break;				
		
		default: echo"An unexpected Error has occured...<br /> Sorry About That :( <br />\n";			
	}
	
	//Free result and Close Database Connection
	pg_free_result($result);
	pg_close(dbconn);
			
?>


</form>		
</body>
</html>
