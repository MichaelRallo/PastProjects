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
    	<script type="text/javascript" src="js/handleBuilds.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/styleSkillSimulator.css" />

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
				<a href="index.php">Home</a>
				<a href="guides.php">Guides</a>
				<a href="classes.php">Classes</a>
				<a href="skillBuilds.php"  class="active">Skill Builds</a>
				<a href="music.php">Music</a>
        </div>
        <div  id="content">
    
        <nav class="navbar navbar-default" id="classNavBar">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">

                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Warrior<span class="caret"></span></a>
                  <ul class="dropdown-menu" >
                    <li>Swords Man</li>
                    <li><a href="#" class="classBuild">Gladiator</a></li>
                    <li><a href="#" class="classBuild">Lunar Knight</a></li>
                    <li role="separator" class="divider"></li>
                    <li>Mercenary</li>
                    <li><a href="#" class="classBuild">Barbarian</a></li>
                    <li><a href="#" class="classBuild">Destroyer</a></li>
                  </ul>
                </li>
                  
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Archer<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li>Sharpshooter</li>
                    <li><a href="#" class="classBuild">Sniper</a></li>
                    <li><a href="#" class="classBuild">Warden</a></li>
                    <li role="separator" class="divider"></li>
                    <li>Acrobat</li>
                    <li><a href="#" class="classBuild">Tempest</a></li>
                    <li><a href="#" class="classBuild">Windwalker</a></li>
                  </ul>
                </li>   
                  
                  <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sorceress<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li>Elementalist</li>
                    <li><a href="#" class="classBuild">Pyromancer</a></li>
                    <li><a href="#" class="classBuild">Ice Witch</a></li>
                    <li role="separator" class="divider"></li>
                    <li>Mysic</li>
                    <li><a href="#" class="classBuild">War Mage</a></li>
                    <li><a href="#" class="classBuild">Chaos Mage</a></li>
                  </ul>
                </li>                
                  
                   <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cleric<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li>Paladin</li>
                    <li><a href="#" class="classBuild">Guardian</a></li>
                    <li><a href="#" class="classBuild">Crusader</a></li>
                    <li role="separator" class="divider"></li>
                    <li>Preist</li>
                    <li><a href="#" class="classBuild">Saint</a></li>
                    <li><a href="#" class="classBuild">Inquisitor</a></li>
                  </ul>
                </li>                     
              </ul>


            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
        <div id="titleScreen"><h1>Please Choose a Class To View Recommended Builds!</h1></div>    
            <div id="threeBuilds" class="group">
                <div class="skillBuildColumn">
                    <div id="firstSkillBuildColumnBanner" class="skillBuildColumnBanner">hello</div>
                    <div id="firstBuild"></div>
                </div>
                <div class="skillBuildColumn">
                    <div id="secondSkillBuildColumnBanner" class="skillBuildColumnBanner">hello</div>
                    <div id="secondBuild"></div>
                </div>
                <div class="skillBuildColumn">
                    <div id="thirdSkillBuildColumnBanner" class="skillBuildColumnBanner">hello</div>
                    <div id="thirdBuild"></div>
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
        </div>	</body>
</html>
