<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
	session_start();

    include("../dbConnect.php");
    secureMe();
    $dbconn = null;
    $dbconn = connectDB($dbconn);	
    $username = $_SESSION['username'];

    $section = "music";			
    $action = "Commented On A Movie";
    $submittedComment = htmlspecialchars($_GET['q']);

    if(!isset($_SESSION['username'])){
        echo"<p style='color:red; float:clear;margin: 0px 0px 0px 0px;'>You Must Be Logged In To Comment!</p>";	
    }

    else if(isset($_SESSION['username']))
    {	
        if($submittedComment == "" || $submittedComment == null || $submittedComment == " "){
            echo"<p style='color:red; float:clear;margin: 0px 0px 0px 0px;'>Please Enter A Valid Comment.</p>";	
        }
        else{								
            //Insert
            date_default_timezone_set('America/Chicago');
            $timestamp = date(DATE_RFC2822); 
            $sql = "INSERT INTO userTables.userComments(username, section, userComment, log_date, action) VALUES($1, $2, $3, $4, $5)";
            pg_prepare($dbconn, 'insert_comment', $sql);
            $resultComment = pg_execute($dbconn, 'insert_comment', array($username, $section, $submittedComment, $timestamp, $action));

            if($resultComment == null){
                echo"<p <p style='color:red;margin-left:400px;'>Error While Inserting.</p>";	
            }

            else{
                echo"<p <p style='color:red;margin-left:400px;'>Thank You For Your Comment..</p>";	
            }
        }						
    }				
						
    //Perform Query and set result equal to returned
    pg_prepare($dbconn, 'comments', "SELECT * FROM userTables.userComments WHERE (section = $1) ORDER BY log_date DESC");
    $resultComments = pg_execute($dbconn, 'comments', array($section));

    while ($rowsForComments = pg_fetch_array($resultComments, null, PGSQL_ASSOC)){	
            $userComment = $rowsForComments['usercomment'];
            $userCommentName = $rowsForComments['username'];
            $timePosted = $rowsForComments['log_date'];

            $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
            $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];

            echo"<div class='panel panel-default panel-danger' style = ' height:auto; width:auto; float:left;  background-color:white; border: solid black 4px; border-radius:10px; padding:5px;'><div class='panel-heading' style='background-color:$color;'><h1 class='panel-title' style='color:white;'>$userCommentName Commented: ($timePosted)</h1></div><div class='panel-body'><p align = 'left'>$userComment</p></div></div>";								
    }
    echo"</div>";
    pg_close($dbconn);
?>
</body>
</html>