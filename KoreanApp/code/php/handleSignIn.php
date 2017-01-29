<?php

function handleSignIn($dbconn){
        //Check if a user is logged in
        if(isset($_SESSION['username'])){
            $username = $_SESSION['username'];

            //Pull User's Records to display information
            $userInfoQuery = sprintf("SELECT * FROM userTables.user_info AS info WHERE (info.username = '%s')", $username);
            mysql_select_db('userTables');
            $resultUserInfo = mysql_query($userInfoQuery, $dbconn) or die ("Could Not Get User Data From Database!");;
            $userInfo = mysql_fetch_array($resultUserInfo, MYSQL_ASSOC);
            
            //While Logged In
            echo"Logged In As: " . $userInfo['username'] . "";
            echo"<a href='php/logoutUser.php'>Logout Here</a>";
            
            mysql_free_result($resultUserInfo);
            return $username;
        }
 
        //While Not Logged in!
        else{	
            //User is not logged in.	
            echo"<a href='login.php'> Login Here</a><br/>";
            echo"<a href='register.php'>Register Here</a>";
        }
}

?>