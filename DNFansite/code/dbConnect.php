<?php
function connectDB() {  
    //Connect To Database
    include("secure/database.php");
    $dbconn = pg_connect(HOST." ".PORT." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());
    if(!$dbconn) 
    {
        echo "<p>Failed to connect to DB</p>\n";
    }
    return $dbconn;
}

function handleSignIn($dbconn){
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
            return $username;
        }

        //While Not Logged in!
        else{	
            //User is not logged in.	
            echo"<a href='login.php' class='bannerText''> Login Here</a><br/>";
            echo"<a href='register.php' class='bannerText'>Register Here</a>";
        }
}

function secureMe(){
 	//Check if using secured https
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $redirect");
	}   
}
?>