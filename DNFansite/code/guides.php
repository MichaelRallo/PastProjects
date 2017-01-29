<?php
	session_start();

    include("dbConnect.php");
    secureMe();
    $dbconn = null;
    $dbconn = connectDB($dbconn);	
?>

<!DOCTYPE html>
<html lang="en" class="no-js demo5">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Final Project</title>
    	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    	<script type="text/javascript" src="js/bootstrap.min.js"></script>
    	<script type="text/javascript" src="js/handleGuides.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/styleGuides.css" />
	</head>
	<body>
	  <div id="wrapper">
        <div id="banner">
            <div align = "right">  
                <a href="index.php"><img src="images/logo5.png" alt="Logo" id="logo"></a>
                <?php $username = handleSignIn($dbconn); ?>
            </div>
        </div>
        <div class="menu">
				<a href="index.php" >Home</a>
				<a href="guides.php" class="active">Guides</a>
				<a href="classes.php">Classes</a>
				<a href="skillBuilds.php">Skill Builds</a>
				<a href="music.php">Music</a>
        </div>
        <div  id="contentHeader">
            <div id="title"><h1>Credit For Guides go To: FreedomPlays</h1></div>
           <div id="dragonsContainer">
                <img src="images/sdn.jpg" alt="sdn" id="sdn" class="dragon"> 
                <img src="images/gdn.jpg" alt="gdn" id="gdn" class="dragon"> 
                <img src="images/ddn.jpg" alt="ddn" id="ddn" class="dragon"> 
                <img src="images/bdn.jpg" alt="bdn" id="bdn" class="dragon"> 
           </div>
            <div id="content"></div>
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
