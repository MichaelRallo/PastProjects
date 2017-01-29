<!-- https://babbage.cs.missouri.edu/~cs3380s15grp7/imdb/index.php -->
<?php
	session_start();
	
	//Check if using secured https
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $redirect");
	}
	
	//Connect To Database
	include("../secure/database.php");
	$dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());
	if(!$dbconn) 
	{
		echo "<p>Failed to connect to DB</p>\n";
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
	
	
    <link href="../src/rateit.css" rel="stylesheet" type="text/css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

    <style>
        body
        {
            font-family: Tahoma;
            font-size: 12px;
            margin: 1em;
        }
        h1
        {
            font-size: 1.7em;
        }
        h2
        {
            font-size: 1.5em;
        }
        h3
        {
            font-size: 1.2em;
        }
        ul.nostyle
        {
            list-style: none;
        }
        ul.nostyle h3
        {
            margin-left: -20px;
        }

        #toc {
            -moz-column-count: 3;
            -webkit-column-count: 3;
            column-count: 3;
            max-width: 1100px;
        }
    </style>
    <!-- alternative styles -->
    <link href="content/bigstars.css" rel="stylesheet" type="text/css">
    <link href="content/antenna.css" rel="stylesheet" type="text/css">
  <link href="content/svg.css" rel="stylesheet" type="text/css">
    <!-- syntax highlighter -->
    <link href="sh/shCore.css" rel="stylesheet" type="text/css">
    <link href="sh/shCoreDefault.css" rel="stylesheet" type="text/css">
</head>
	

	<title>Group 7 IMDB Top Ten</title>
</head>
<body>


<div id="loginPageContainer">
	<!--Header For Logo/Login/Logout/Register-->
	<div class="row" style="padding-top: 20px;opacity:.80;">
		<div class="col-xs-12 " >
			<div class="well" style = " background-image: url('images/headbg.gif');">
				<div align = "right">  
					<a href="index.php"> <img src="images/webLogo2.gif" alt="Logo" style="float:left; width:100px; height:80px; margin:-8px 0px"></a>

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


	
	<div style="width:800px; height: 400px; background-color:white; align:center; margin:auto; border-radius:6px; padding:20px;">
<?php

	
	//Grab keys from index query
	$topPick = htmlspecialchars($_GET['topPick']);
	$topPick = "movie";
			switch($topPick)
			{	
				case movie: 	
				echo"<h1 align = 'center'>Top 10 Rated Movies:</h1>";
				
						?><div class="rateit bigstars" data-rateit-starwidth="32" data-rateit-starheight="32"></div><?php
						break;
				
				case actor:
				echo"<h1 align = 'center'>Top 10 Rated Actors:</h1>";				
				/*
						//Perform Query and set result equal to returned
						$result = pg_prepare($dbconn, 'my_query', "SELECT * FROM imdb2.actor WHERE (id = $1)");
						$result = pg_execute($dbconn, 'my_query', array($id));
						$line = pg_fetch_array($result, null, PGSQL_ASSOC);
						
						//Grab Data From What was returned
						$id = $line['id'];
						$fname = $line['fname'];
						$lname = $line['lname'];
						$gender = $line['gender'];

						if($fname == null)
							$name = "N/A";
										
						if($lname == null)
							$lname = "N/A";
							
						if($gender == null)
							$gender = "N/A";
						
						echo"<h1 align = 'center'>Actor Details</h1>";
						echo nl2br("\n\nActor Information is: ");
						echo nl2br("\nId: " . $id);
						echo nl2br("\nFirst Name: " . $fname);
						echo nl2br("\nLast Name: " . $lname);
						echo nl2br("\nGender: " . $gender);
				*/								
						break;
								
				case director:	
				echo"<h1 align = 'center'>Top 10 Rated Directors:</h1>";
				/*
						//Perform Query and set result equal to returned
						$result = pg_prepare($dbconn, 'my_query', "SELECT * FROM imdb2.directors WHERE (id = $1)");
						$result = pg_execute($dbconn, 'my_query', array($id));
						$line = pg_fetch_array($result, null, PGSQL_ASSOC);
						
						//Grab Data From What was returned
						$id = $line['id'];
						$fname = $line['fname'];
						$lname = $line['lname'];

						if($fname == null)
							$name = "N/A";
										
						if($lname == null)
							$lname = "N/A";

						echo"<h1 align = 'center'>Director Details</h1>";
						echo nl2br("\n\nDirector Information is: ");
						echo nl2br("\nId: " . $id);
						echo nl2br("\nFirst Name: " . $fname);
						echo nl2br("\nLast Name: " . $lname);
				*/							
						break;

				default : 		
				
						$table = null;
						header('Location: index.php');
						break;
			}			


	pg_close($dbconn);

	
?>
	</div>
	
	
	
	
	
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

