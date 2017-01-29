<!DOCTYPE html>
<?php 
session_start();
include("secure/database.php");
$dbconn = connectDB();            
?>
<html>
<head>
<title>Page Title</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/addwordpopup.css">
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
    .panel *{
        
        text-align: center;
    }
    .words-group{
        list-style: none;
        font-size: 18px;
    }
    .type-header{
        font-size: 21px;
        text-transform: capitalize;
    }
    .words-group li:nth-child(even) {
        background-color:gray;
    }
    .words-group li:nth-child(even) {
        background-color:#F0F0F0;
    }
    .panel-heading, .type-header{
        cursor: pointer;
    }
    .koreanCol{
        float:right;
    }
    .englishCol{
        float:left;
    }
    #add-words{
        cursor: pointer;
    }
    .selected{
        background-color:greenyellow !important;
    }
    .words-group>li{
        cursor: pointer;
    }
    #start-practice, #back-to-selection{
        color: #003478;
        text-decoration: underline;
        cursor: pointer;
    }
    #start-practice:hover, #back-to-selection:hover{
        color: #c60c30;
    }
    .choice-container{
        padding:10px;
        min-height: 45px;
    }
    .choice{
        width: 100%;
        height:100%;
        display: inline-block;
        font-size: 32px;
        background-color: #003478;
        color: #F3F3F3;
        position: relative;
        text-align: center;
        min-height: 20px;
        cursor: pointer;
    }
    .choice:hover{
        color:white;
        background-color: #006699;
    }
    .question-container{
        text-align: center;
        font-size: 36px;
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
                        printf("<li style='cursor:default'><a>Logged in As: <span id='user-id'>%s</span></a></li>", $_SESSION['username']);
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
    
    
    
    <div id="content-container" style="background-color:#F3F3F3;margin: 50px auto;padding-bottom: 50px;" class="container">
        <div id="game-container" style="display:none;">
            <h3>Enjoy!</h3>
            <h4 id="back-to-selection">Choose Different Words</h4>
            <br><br><br>
            <div id="game-pane">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 question-container"><span id="question"></span></div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 choice-container"><span id="choice-1" class="choice"></span></div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 choice-container"><span id="choice-2" class="choice"></span></div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 choice-container"><span id="choice-3" class="choice"></span></div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 choice-container"><span id="choice-4" class="choice"></span></div>                 
            </div>
            
        </div>
        <div id="word-selection-container">
            <h3>Practice Words</h3>
            <h4>Select Your Words and Hit <span id="start-practice">Start</span> to Practice!</h4>    
            <?php 
            if(isset($_SESSION['username'])){
                printf("<a id='add-words' class='addWordsEngine_open'>Add Words!</a>");
            }else{
                printf("<p>Log in to Add Words!</p>");
            }
            ?>
            <div id="start-errors-container"></div>
            <div id="words-container"></div>
        </div>
    </div>

    <!-- jQuery -->
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.popupoverlay.js"></script>
    

    
    
    <!-- This is the Container for the Popup when a user tries to add words -->
    <div id="addWordsContainer" aria-hidden="false">
        <!-- The Container for the Search Stuffs, you need to keep the same id/class names! -->
        <div id="addWordsEngine">
            <!-- X - Close Out of Menu -->
            <em class="fa fa-times addWordsEngine_close closeStyles" aria-hidden="true"></em>
            <h1>Add Words!</h1>
            <form id="userInformationForm" class="form-horizontal">
                <!-- Form Fields -->
                <div class="form-group">
                    <label for="username" class="col-sm-4 control-label">Korean:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control userInformationFormField" id="Korean" name="Korean" placeholder="Korean"> 
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-sm-4 control-label">English:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control userInformationFormField" id="English" name="English" placeholder="English"> 
                    </div>
                </div>

                <div class="form-group">
                    <label for="text" class="col-sm-4 control-label">Pronounciation:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control userInformationFormField" id="Pronounciation" name="Pronounciation" placeholder="Pronounciation"> 
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-4 control-label"></label>
                    <div class="col-sm-8">
                        <input id="submitButton" class="form-control" type="button" name="submit" value="submit">
                    </div>
                </div>

            </form>
            <!-- Error Messages -->
            <p id="errors-container"></p>
        </div>
    </div>
    
    <script type="text/javascript" src="js/gameManager.js"></script>
    <script type="text/javascript" src="js/restful.js"></script>

</body>
</html>





















































