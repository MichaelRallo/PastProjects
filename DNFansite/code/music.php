<?php
	session_start();

    include("dbConnect.php");
    secureMe();
    $dbconn = null;
    $dbconn = connectDB($dbconn);	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Final Project</title>
    	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    	<script type="text/javascript" src="js/bootstrap.min.js"></script>
    	<script type="text/javascript" src="js/musicHandlerRevamped.js"></script>
    	<script type="text/javascript" src="js/musicCommentAjaxRequest.js"></script>
        <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/styleMusic.css" />
        <style></style>
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
				<a href="guides.php">Guides</a>
				<a href="classes.php">Classes</a>
				<a href="skillBuilds.php">Skill Builds</a>
				<a href="music.php" class="active">Music</a>
        </div>
          
        <div id="content">
            <div id="musicContainer" class="group">
            <div id="classSelectionContainer" class="classSelection">
                <div id="warrior" value="warrior"></div>
                <div id="archer" value="archer"></div>
                <div id="cleric" value="cleric"></div>
                <div id="sorceress" value="sorceress"></div>           
            </div>      
            
            </div>
            <div id="classSelectionContainerSmall" class="classSelection">
                <div id="clericSmall" value="cleric"></div>
                <div id="warriorSmall" value="warrior"></div>
                <div id="archerSmall" value="archer"></div>
                <div id="sorceressSmall" value="sorceress"></div>           
            </div>      
               
            <div id="postCommentContainer">
                <h1>Comments~</h1>
                <h3>Submit Your Own Comment/Comment</h3>
                <div id='textAreaContainer'><textarea text-align='center' id ='userCommentText' rows='5' cols='55' maxlength='250'></textarea>
                    <?php if(isset($_SESSION['username']))
                        print("<input id='commentSubmit' type='button' name='commentSubmit' value='Submit' />");
                    ?>
                </div>   
                <div id="limit">
                    <div id="commentSection"></div>
                </div>
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
