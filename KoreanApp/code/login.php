<!DOCTYPE html>
<?php 
session_start();
//Check if a user is logged in
if(isset($_SESSION['username'])){	
    header('Location: index.php');
}

include("php/loginUser.php");
include("secure/database.php");
$dbconn = connectDB();
?>
<html>
<head>
<title>Page Title</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="css/main.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
 /*****Font Settings*****/
    @font-face {
    font-family: 'Eras Light ITC';
    font-style: normal;
    font-weight: normal;
    src: local('Eras Light ITC'), url('fonts/ERASLGHT.woff') format('woff');
    }
    
    *{
        padding:0px;
        margin: auto;
    }
    
    body{
        background-color:#003478;
    }
    .no-padding{
        padding: 0px;
    }
    .no-margin{
        margin: 0px;
    }
    
    
    /*Header*/    
    #header{
        background-color: transparent;
    }
    #header-wrapper{
        background-color: #F3F3F3;
    }
    
    /*Right Nav*/
    #main-navigation-list{
        float: right;
        padding-top: 17px;
    }

    #main-navigation-list>li{
        display: inline-block;
        height: auto;
    }
    #main-navigation-list>li>a{
        color: dimgray;
        font-size: 21px;
        position: relative;
        width: 100%;
        padding-left: 15px;
        padding-right: 15px;
        font-family: Eras Light ITC;
        font-weight: bold;
    }
    #main-navigation-list>li>a:hover{
        text-decoration: none;
        color: black;
    }
    #main-navigation-list li > a:before {
      content: "";
      position: absolute;
      width: 100%;
      height: 1px;
      top: 25px;
      left: 0;
      background-color: #003478;
      visibility: hidden;
      -webkit-transform: scaleX(0);
      transform: scaleX(0);
      -webkit-transition: all 0.3s ease-in-out 0s;
      transition: all 0.3s ease-in-out 0s;
    }    

    #main-navigation-list li > a:hover:before {
      visibility: visible;
      -webkit-transform: scaleX(1);
      transform: scaleX(1);
    }    
    
    /*Logo Stuff*/
    #logo-container{
        z-index: 1;
    }
    #logo-container *{
        display: inline;
    }
    #logo-text{
        font-size: 21px;
        font-family: Eras Light ITC;
        color: black;
    }
    #logo-text:hover{
        text-decoration: none;
        color: dimgray;
    }
   
    @media (max-width: 600px){
        #main-navigation-list, #navigation-list{
            float: none;
            text-align: center;
            padding-top: 5px;
            width: 100%;
            margin:auto;
        } 
        #logo-container{
            text-align: center;
            width: 100%;
            margin:auto;
        }
    }
    @media(max-width: 380px){
        #logo-container *{
            display: block;
        }
    }
</style>
</head>
<body>
    <div id="header-wrapper" class="container-fluid">
        <div id="header" class="container no-padding">
            <div id="logo-container" class="col-lg-7 col-md-7 col-sm-7 col-xs-7 no-padding no-margin">
                <a href="index.php"><img class="img-responsive" src="images/flag.png" height="150px" width="100px" style="z-index: 1;"></a>
                <a href="index.php" id="logo-text">Korean Learning Service</a>
            </div>
            <div id="navigation-list" class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding no-margin">
                <ul id="main-navigation-list" class="no-margin no-padding">
                    <li><a href="practice.php">Start Practice</a></li>   
                                        <?php 
                    if(isset($_SESSION['username'])){
                        printf("<li style='cursor:default'><a>Logged in As: %s</a></li>", $_SESSION['username']);
                        printf("<li><a href='php/logoutUser.php'>Logout</a></li>");
                    }else{
                        printf("<li><a href='login.php'>Login<span class=\"sr-only\">(current)</span></a></li>");
                        printf("<li><a href='register.php'>Register</a></li>");
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div style="background-color:#F3F3F3;margin: 50px auto;padding-bottom: 50px;" class="container">
    <h3>Login</h3>
            <span style="color:red">
            <?php
                if (isset($_POST['submit'])){
                    $username = htmlspecialchars($_POST['username']);
	                $password = htmlspecialchars($_POST['password']);	
                    loginUser($dbconn, $username, $password);
                }
            ?>
            </span>
            <!-- Our Form, Note it's using POST method. -->
            <form id="userInformationForm" class="form-horizontal" action="<?= $_SERVER['PHP_SELF'] ?>"method="POST">
                <!-- Form Fields -->
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Username:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control userInformationFormField" id="username" name="username" placeholder="First Name"> 
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password:</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control userInformationFormField" id="password" name="password" placeholder="Password"> 
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        <input class="form-control" type="submit" name="submit" value="submit">
                    </div>
                </div>
                
            </form>
            <h4>Don't Have An Account? Register <a href="register.php">here</a>.</h4>
        
             
    </div>
    
<?php mysql_close($dbconn); ?>
</body>
</html>






















































