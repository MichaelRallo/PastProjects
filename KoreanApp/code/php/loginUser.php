<?php

function loginUser($dbconn, $username, $password) { 

    //See If User Exists
    $checkUserQuery = sprintf("SELECT * FROM userTables.authentication AS auth WHERE (auth.username = '%s')", $username);
    mysql_select_db('userTables');
    $resultCheckUser = mysql_query($checkUserQuery, $dbconn);
    if(!$resultCheckUser ){
            die('Could not get data: ' . mysql_error());
    }
    
	
    $userRow = mysql_fetch_array($resultCheckUser, MYSQL_ASSOC);
    mysql_free_result($resultCheckUser);
    
    if($userRow == NULL){	//Invalid Username, Try Again
		echo"<h5><center>Incorrect Username or Password</center></h5>";
		echo"<h4><center>Please Enter Your Login Information Again</center></h4>";	
	}
    
	else{	//User Exists... Check Password
		$salt = $userRow['salt'];
		$password_hash = sha1($salt . $password);
	
        
        $checkPasswordQuery = sprintf("SELECT * FROM userTables.authentication AS auth WHERE (auth.username = '%s' AND auth.password_hash = '%s')",$username, $password_hash);
        mysql_select_db('userTables');
        $resultCheckPassword = mysql_query($checkPasswordQuery, $dbconn) or die("Error while Logging In.");
        if(!$resultCheckUser ){
                die('Could not get data: ' . mysql_error());
        }
        
        
        $userRow = mysql_fetch_array($resultCheckPassword, MYSQL_ASSOC);
        mysql_free_result($resultCheckPassword);
        
        
		if($userRow != NULL){	//Password Matched!
			echo"Passwords Matched!";

			$_SESSION['username'] = $username;
			header('Location: index.php');
		}
		else{	//Invalid Password, Try Again
            echo"<h5><center>Incorrect Username or Password</center></h5>";
			echo"<h4><center>Please Enter Your Login Information Again</center></h4>";
		}
	}   
    
}
?>


