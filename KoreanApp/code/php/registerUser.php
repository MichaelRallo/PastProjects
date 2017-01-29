<?php


function registerUser($dbconn, $username, $password) { 

    //Check if a user is logged in
	if(isset($_SESSION['username']))
	{	
		header('Location: index.php');
	}
    
    if($username == null || $password ==null || $username == "" || $password == ""){
			echo"<center>Sorry, Invalid Username/Password. Please Try Again.</center>\n";
    }
    else{
         //See If User Already Exists
        $checkUserQuery = sprintf("SELECT * FROM userTables.authentication AS auth WHERE (auth.username = '%s')",$username);
        mysql_select_db('userTables');
        $resultCheckUser = mysql_query($checkUserQuery, $dbconn) or die ("Could Not Check if User Exists!");

        $userRow = mysql_fetch_array($resultCheckUser, MYSQL_ASSOC);
        mysql_free_result($resultCheckUser);   
        
        if($userRow == NULL){	//Username is Available! Add it into database.

            //Note, mt_rand is more powerful than rand.
            $salt =  sha1(mt_rand(0, 39));
            $password_hash = sha1($salt . $password);
            $admin = false;
            $timestamp = date('Y-m-d G:i:s');
            
            //Add User To Database, Inserting Information Respectively
            $registerUserQuery = sprintf("INSERT INTO userTables.user_info(username, registration_date) VALUES ('%s', '%s')", $username, $timestamp);
            mysql_select_db('userTables');
            $resultRegisterUser = mysql_query($registerUserQuery, $dbconn) or die ("Could Not Add User To Database!");;
            
            //Add User's Authentication Stuff to Database
            $registerPasswordQuery = sprintf("INSERT INTO userTables.authentication(username, password_hash, salt) VALUES ('%s', '%s', '%s')", $username,$password_hash,$salt);
            mysql_select_db('userTables');
            $resultRegisterPassword = mysql_query($registerPasswordQuery, $dbconn) or die("Could Not Add User Authication To Database!");
            
          	$_SESSION['username'] = $username;
            header('Location: index.php');				
				
        }
        else{	//Username already exists.
				echo"<center>Sorry, Username already Exists. Please Try Again.</center>\n";
			}
    }
    

    
}
?>


