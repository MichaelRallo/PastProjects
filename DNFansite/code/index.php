<?php
	session_start();
	
	//Check if using secured https
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $redirect");
	}

	//Connect To Database
	include("secure/database.php");
	$dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());
	if(!$dbconn) 
	{
		echo "<p>Failed to connect to DB</p>\n";
	}	
?>

<!DOCTYPE html>
<html lang="en" class="no-js demo5">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Final Project</title>
    	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    	<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/styleIndex.css" />

	</head>
	<body>
	  <div id="wrapper"> 
     	<!--Header For Logo/Login/Logout/Register-->
        <div id="banner">
            <div align = "right">  
                <a href="index.php"><img src="images/logo5.png" alt="Logo" id="logo"></a>
                <?php 			
                    //Check if a user is logged in
                    if(isset($_SESSION['username'])){
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
                        echo"\n<p class='bannerText''>Logged In As: " . $user_info['username'] . "</p>";
                        echo"\t | \t<a href='logout.php' class='bannerText''>Logout Here</a>";
                    }
						
                    //While Not Logged in!
                    else{	
                        //User is not logged in.	
                        echo"<a href='login.php' class='bannerText''> Login Here</a><br/>";
                        echo"<a href='register.php' class='bannerText'>Register Here</a>";
                    }
                ?>
            </div>
		</div>
          
        <div class="menu">
				<a href="index.php" class="active">Home</a>
				<a href="guides.php">Guides</a>
				<a href="classes.php">Classes</a>
				<a href="skillBuilds.php">Skill Builds</a>
				<a href="music.php">Music</a>
        </div>
        <div  id="content">
            <div id="trailer">
            <iframe width="1000" height="550" src="https://www.youtube.com/embed/lkKL_E3Yv68" frameborder="0" allowfullscreen></iframe>
            </div>
            
        </div>  
          
          
        </div>    
        <div id="footer">
            <div id="navbar" >
                <ul>
                    <li><a href="index.php" >Home |</a></li>
                    <li><a href="guides.php" >Guides |</a></li>
                    <li><a href="classes.php">Classes |</a></li>
                    <li><a href="skillBuilds.php">Skill Builds |</a></li>
                    <li><a href="music.php">Music |</a></li>
                </ul>
            &copy; 2015 Michael Rallo - SaintSaves <br />
            </div>
        </div>
	</body>
</html>
