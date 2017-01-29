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
		header('Location: index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset=UTF-8>

	<!-- Styles/Scripts-->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">   
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<link rel="stylesheet" 
	href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
	<script type="text/javascript" 
	src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" 
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<link href="style.css" rel="stylesheet" type="text/css" />

	<title>4Reelz Register</title>
</head>
<body>


<div id="loginPageContainer">
	<!--Header For Logo/Login/Logout/Register-->
	<div class="row" style="padding-top: 20px;opacity:.80;">
		<div class="col-xs-12 " >
			<div class="well" style = " background-image: url('images/logo5.gif');">
				<div align = "right">  
					<a href="index.php"> <img src="images/logo20.gif" alt="Logo" style="float:left; width:100px; height:80px; margin:0px 0px 0px -15px;opacity:.80;"></a>

					<?php 			
						//Check if a user is logged in
						if(isset($_SESSION['username']))
						{
							$username = $_SESSION['username'];
							
							//Pull User's Records to display information
							$sql = "SELECT * FROM userTables.user_info AS info WHERE (info.username = $1)";
							pg_prepare($dbconn, 'my_query5', $sql);
							$result = pg_execute($dbconn, 'my_query5', array($username)) or die("Error while Logging In.");	
							$user_info = pg_fetch_array($result, null, PGSQL_ASSOC);
							pg_free_result($result);	
							
							$sql = "SELECT * FROM userTables.log AS log WHERE (log.username = $1) ORDER BY log.log_date DESC";
							pg_prepare($dbconn, 'my_query6', $sql);
							$result2 = pg_execute($dbconn, 'my_query6', array($username)) or die("Error while Logging In.");	
							
							//While Logged In
							
							echo"\n<p style='font-size:1.4em;color:WHITE;'>Logged In As: " . $user_info['username'] . "</p>";
							echo"\t | \t<a href='logout.php' style='font-size:1.4em;color:WHITE;'>Logout Here</a>";
						}
						
						//While Not Logged in!
						else
						{	//User is not logged in.
							
								echo"<a href='login.php' style='font-size:1.6em;color:WHITE;'> Login Here</a><br/>";
								echo" <a href='register.php' style='font-size:1.6em;color:WHITE;'>Register Here</a>";
							
						}
					?>
				</div>
			</div>
		</div>
	</div>

	<!--Nav Bar -->	
	<div class="navbar navbar-default navbar-inverse nav-justified" align = "center" style="padding:5px 20px;">
		<div class="navbar-header">
			<ul class="nav navbar-header nav-justified">
				<li><a href="search.php" class="navbar-brand"  style="padding:15px 20px;" >Search</a></li>
				<li><a href="topTen.php?topPick=movie" class="navbar-brand"  style="padding:15px 20px;">Top Movies</a></li>
				<li><a href="topTen.php?topPick=actor" class="navbar-brand"  style="padding:15px 20px;">Top Actors</a></li>
				<li><a href="topTen.php?topPick=director" class="navbar-brand"  style="padding:15px 20px;">Top Directors</a></li>
				<li><a href="information.php" class="navbar-brand"  style="padding:15px 20px;">Information</a></li>
			</ul>
		</div>
	</div>

	<div align = "center">          
		<div id = "login"
		  <p>Please register
		  <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
			  <label for="username">username:</label>
			  
			  <input type="text" name="username" id="username">
			  <label for="password">password:</label>
			  <input type="password" name="password" id="password">
			  <br>
			  <input type="submit" name="submit" value="submit">
		  </form> 
		  </p>
		</div>
	</div>
<?php
	if (isset($_POST['submit'])) 
	{
		
		//Connect To Database
		include("../secure/database.php");
		$dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());
		if(!$dbconn) 
		{
			echo "<p>Failed to connect to DB</p>\n";
		}	
		
		//Grab User Input
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);

		/*
		$username = 'dustin';
		$password ='rios';
		*/
		
		//Check for empties
		if($username == null || $password ==null || $username == "" || $password == "")
		{
			echo"<center>Sorry, Invalid Username/Password. Please Try Again.</center>\n";
			echo"<center>Return to <a href='register.php'>registration page</a></center>\n";			
		}
		else
		{
			
		
			//See if User Already Exists
			$sql = "SELECT * FROM userTables.authentication AS auth WHERE (auth.username = $1)";
			pg_prepare($dbconn, 'my_query', $sql);
			$result = pg_execute($dbconn, 'my_query', array($username)) or die("Error while inserting.");
					
			$line = pg_fetch_array($result, null, PGSQL_ASSOC);
			if($line == NULL)
			{	//Username is Available! Add it into database.

				//Note, mt_rand is more powerful than rand.
				$salt =  sha1(mt_rand(0, 39));
				$password_hash = sha1($salt . $password);
				$timestamp = date('Y-m-d G:i:s');
				$action = "Register";
				$ip_address = $_SERVER['REMOTE_ADDR'];
				
				//Add User To Database, Inserting Information Respectively
				
				if($username == 'Mike' || $username == 'dustin')
				{
					$admin = true;
					$sql = "INSERT INTO userTables.user_info(username, registration_date, is_admin) VALUES ($1, $2, $3)";
					pg_prepare($dbconn, 'my_query1', $sql);
					pg_execute($dbconn, 'my_query1', array($username, $timestamp, $admin)) or die("<br /> Error while inserting.");
						
				}
				
				else
				{
					$admin = false;
					$sql = "INSERT INTO userTables.user_info(username, registration_date) VALUES ($1, $2)";
					pg_prepare($dbconn, 'my_query1', $sql);
					pg_execute($dbconn, 'my_query1', array($username, $timestamp)) or die("<br /> Error while inserting.");									
				}

				
				$sql = "INSERT INTO userTables.log(username, ip_address, log_date, action) VALUES ($1, $2, $3, $4)";
				pg_prepare($dbconn, 'my_query2', $sql);
				pg_execute($dbconn, 'my_query2', array($username, $ip_address, $timestamp, $action)) or die("<br /> Error while inserting.");		
				
				$sql = "INSERT INTO userTables.authentication(username, password_hash, salt) VALUES ($1, $2, $3)";
				pg_prepare($dbconn, 'my_query3', $sql);
				pg_execute($dbconn, 'my_query3', array($username, $password_hash, $salt)) or die("<br /> Error while inserting.");
				
				
				
				
				$_SESSION['username'] = $username;
				header('Location: index.php');
			}
			else
			{	//Username already exists.
				echo"<center>Sorry, Username already Exists. Please Try Again.</center>\n";
				echo"<center>Return to <a href='register.php'>registration page</a></center>\n";
			}
		}
		pg_close($dbconn);
	} //End If Isset
?>

</div> <!--End Body Container-->
</body>

<!--Footer-->
<div class="container" style="padding:0px 60px;">
	<footer class="clearfix">
		<div id="navbar" >
			<ul>
				<li><a href="index.php" >Home |</a></li>
				<li><a href="search.php">Search |</a></li>
				<li><a href="topTen.php?topPick=movie">Top Movies |</a></li>
				<li><a href="topTen.php?topPick=actor">Top Actors |</a></li>
				<li><a href="topTen.php?topPick=director">Top Directors |</a></li>
				<li><a href="information.php">Information |</a></li>
			</ul>
		&copy; 2015 CS3380 Group 7 <br />
		</div><!--Closes Navbar and Other Info laws-->
	</footer>
</div>									
</html>

