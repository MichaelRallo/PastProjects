<?php
	session_start();

	//Check if a user is logged in
	if(isset($_SESSION['username']))
	{	
		header('Location: index.php');
	}

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
    	<script type="text/javascript" src="js/musicHandlerRevamped.js"></script>
        <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Latest compiled and minified CSS -->

        
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/styleLogin.css" />
        <style></style>
	</head>
	<body>
	  <div id="wrapper"> 
     	<!--Header For Logo/Login/Logout/Register-->
        <div id="banner">
             <div align = "right">  
                <a href="index.php"><img src="images/logo5.png" alt="Logo" id="logo"></a>
                <?php $username = handleSignIn($dbconn); ?>
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

<div align = "center">          
		<div id = "login">
		  <p><h1>Please register</h1>
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
	if (isset($_POST['submit'])) {
		//Grab User Input
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);

		if($username == null || $password ==null || $username == "" || $password == ""){
			echo"<center>Sorry, Invalid Username/Password. Please Try Again.</center>\n";
			echo"<center>Return to <a href='register.php'>registration page</a></center>\n";			
		}
		else{
			//See if User Already Exists
			$sql = "SELECT * FROM userTables.authentication AS auth WHERE (auth.username = $1)";
			pg_prepare($dbconn, 'my_query', $sql);
			$result = pg_execute($dbconn, 'my_query', array($username)) or die("Error while inserting.");
					
			$line = pg_fetch_array($result, null, PGSQL_ASSOC);
			if($line == NULL){	//Username is Available! Add it into database.

				//Note, mt_rand is more powerful than rand.
				$salt =  sha1(mt_rand(0, 39));
				$password_hash = sha1($salt . $password);
				$timestamp = date('Y-m-d G:i:s');
				$action = "Register";
				$ip_address = $_SERVER['REMOTE_ADDR'];
				
				//Add User To Database, Inserting Information Respectively
				if($username == 'Mike' || $username == 'dustin'){
					$admin = true;
					$sql = "INSERT INTO userTables.user_info(username, registration_date, is_admin) VALUES ($1, $2, $3)";
					pg_prepare($dbconn, 'my_query1', $sql);
					pg_execute($dbconn, 'my_query1', array($username, $timestamp, $admin)) or die("<br /> Error while inserting.");
						
				}
				
				else{
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
			else{	//Username already exists.
				echo"<center>Sorry, Username already Exists. Please Try Again.</center>\n";
				echo"<center>Return to <a href='register.php'>registration page</a></center>\n";
			}
		}
		pg_close($dbconn);
	} //End If Isset
?>                
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
