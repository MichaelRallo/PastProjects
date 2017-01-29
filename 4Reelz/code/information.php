<!-- https://babbage.cs.missouri.edu/~cs3380s15grp7/imdb/index.php -->
<!-- 90b434cc -->
<!-- http://www.radioactivethinking.com/rateit/example/example.htm#ex_a1 -->
<?php
	session_start();
	
	//Check if using secured https
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $redirect");
	}
	
	//Connect To Database
	include("../secure/database.php");
	$dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());
	if(!$dbconn) 
	{
		echo "<p>Failed to connect to DB</p>\n";
	}	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset=UTF-8>

	<!-- Styles/Scripts-->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">   
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<link rel="stylesheet" 
	href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
	<script type="text/javascript" 
	src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" 
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<link href="style.css" rel="stylesheet" type="text/css" />

	<title>4Reelz Information</title>
</head>
<body>


<div id="loginPageContainer" style="height: 8000px; background-image: none;">
	<!--Header For Logo/Login/Logout/Register-->
	<div class="row" style="padding-top: 20px;opacity:.80;">
		<div class="col-xs-12 " >
			<div class="well" style = " background-image: url('images/logo5.gif');">
				<div align = "right">  
					<a href="index.php"> <img src="images/logo20.gif" alt="Logo" style="float:left; width:100px; height:80px; margin:0px 0px 0px -15px;opacity:.80;"></a>

					<?php 			
						//Check if a user is logged in
						if(isset($_SESSION['username']))
						{
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
							$user = $user_info['is_admin'];							
							if($user == 't'){echo"\n<p style='font-size:1.4em;color:GOLD;'>Logged In As: " . $user_info['username'] . "</p>";}							
							else{echo"\n<p style='font-size:1.4em;color:WHITE;'>Logged In As: " . $user_info['username'] . "</p>";}
							echo"\t | \t<a href='logout.php' style='font-size:1.4em;color:WHITE;'>Logout Here</a>";
						}
						
						//While Not Logged in!
						else
						{	//User is not logged in.
							
								echo"<a href='login.php' style='font-size:1.6em;color:WHITE;'> Login Here</a><br/>";
								echo" <a href='register.php' style='font-size:1.6em;color:WHITE;'>Register Here</a>";
							
						}
					?>
				</div>
			</div>
		</div>
	</div>

	<!--Nav Bar -->	
	<div class="navbar navbar-default navbar-inverse nav-justified" align = "center" style="padding:5px 20px;">
		<div class="navbar-header">
			<ul class="nav navbar-header nav-justified">
				<li><a href="search.php" class="navbar-brand"  style="padding:15px 20px;" >Search</a></li>
				<li><a href="topTen.php?topPick=movie" class="navbar-brand"  style="padding:15px 20px;">Top Movies</a></li>
				<li><a href="topTen.php?topPick=actor" class="navbar-brand"  style="padding:15px 20px;">Top Actors</a></li>
				<li><a href="topTen.php?topPick=director" class="navbar-brand"  style="padding:15px 20px;">Top Directors</a></li>
				<li><a href="information.php" class="navbar-brand"  style="padding:15px 20px;">Information</a></li>
			</ul>
		</div>
	</div>

<div align = "left"> 
<p>This Page is to keep track of progess/updates... Will Later Be Converted Into Actual Info Page.

*********************************************************************************************************************************************


<br /><br /><p style="color:red;">TO DO LIST <br / > Next Meeting Time: 5/2/2015 2:00pm Student Center.
				<br /><br/>***!Top Priorities!***
				
				
				
				<br /><br />-There Are No Last Names For Directors In Out Database! Really Need those.
				<br /><br />-Movie Descriptions Will Really Add A Lot To The Site, See If We Can Get Those!
				<br />-Not For Sure If Kara/Dustin Managed To "Scrap Them" from other Sites
				
				<br /><br />-Not For Sure If We Have, But Need Genres For Movies~!
				<br />--If They Are Available Someone Can Add Buttons Into The Search Page Which Limits Results To Those Genre Movies
				<br />--This Can Also Be Implemented Into The Top Ten Pages
		
				<br /><br />-Ratings for Users Is Comepleted, Ratings For Movies Are Not!
				<br />--See if We Can Get Those Filled In Into The Database
				<br /><br />-Top Movies Page Needs To Be Completed
				<br /><br />-Top Actors Page Needs To Be Completed
				<br /><br />-Top Directors Page Needs To Be Completed
				

				
			</p>
Note, if Working on Project, Be Sure To Save Frequently!
<br />Also, may be worth Skyping if Two+ People Are Working On Project At Same Time~
<br />Mike's Sykpe: gutsmanx
<br />
<br />-Need Rating System Up And Going
<br />-Need Handler For Unloadable Pictures (There Should be Some Workable J-Scripts)
<br />-Need Star Slider For Rating System <span style="color:green;">(Could Use Work... Image API that I am using feels weak. Google's API you have to pay for. Any Word From OMDB? -Mike)</span>
<br />-Need Movie/Actor/Director Images <span style="color:green;">(In Progress -Mike)</span>
<br />-Need Queries To Join Tables Resulting in Movie Relating To Actors/Ratings/Directors/Etc
<br />-Need Queries To Return Top 1000/10 Movies By Rank!
<br />-Need Reviewing System Still
<br />-Need Top Movies, Top Actors, Top Directors Pages Still... Can Combine into one with switch statement instead if desired.
<br />-Need PowerPoint Presentation
<br />-Need 20 Page Paper
<br />-SlideShow Banner for Home Would Be Tight
<br />-User Profile Page Listing Activity... Maybe
<br />-Column With Genres For More Specified Search
<br />-Create Movie Insert Page Only Available To Admins... Maybe
<br />-Enable Users To Rate Comments/Reviews As Well <span style="color:green;">(In Progress -Mike)</span>

<!-------------------------------------------------------------------------------------------------------------------------------->

<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************

<br /><br /><p style="color:green;">UPDATES/PROGRESS :: Subject To Change</p>
<br />4/28/15
<br />Group 7 IMDB V0.1
<br />-Implemented Working Log-In System -Mike
	<br />--Previous system was missing authentification/checking
	  and had bugs
	<br />--Added userTables.sql to store user information
	 (Can later be implemented with main sql file if desired)
	<br />--Includes User Info, Authentification, and Logs tables.
	
<br /><br />-Updated Index to display currently logged in users -Mike
	<br />--If User is logged in they cannot access login/register page
	<br />--User Has link to logout now
	
<br /><br />-Implemented log-out page -Mike

<br /><br />-Implemented secured site browsing (Always HTTPS) -Mike

<br /><br />-Added Suggested Logo in Images Folder -Mike

<br /><br />-Added Working Query Searches For Movies, Actors, and Directors -Mike

<br /><br />-Resolved First Name Last Name Search Issue by Including Search for Both At Same Time With "OR" -Mike

<br /><br />-Added Function to Keep Drop Down Type Search Selected After Query Has Been Executed -Mike

<br /><br />-Limited Query returns to 10 to ensure Page does not timeout... We will need to find a way to split into seperate pages for results ?  -Mike
		<br />--Recommended to make a container to hold results and make container changeable via pages 1, 2, 3, 4 ... at bottom right corner.
		
<br /><br />-***Noticed Data in database still funky... Even some movie titles are characters. May Need to find better source for data?**- -Mike

<br /><br />-Implemented Logo That Links Home -Mike

<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************

<br /><br />4/28/15
<br />Group 7 IMDB V0.2
<br /><br />-Reduced Amount of Data Return by Query Searches To Only Significant Data (i.e. Movie will only return name/year released) -Mike

<br /><br />-Implemented If query returns a blank/null value for year/names, setted as "N/A" -Mike

<br /><br />-Added Details Information Page! -Mike

<br /><br />-Added links attached to returned movies to lead to their details page. -Mike

<br /><br />-Added dynamic changing Details Page -Mike

<br /><br />-Implemented links onto actors and director results as well to point to their details page. -Mike

<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************

<br />4/29/15
<br />Group 7 IMDB V1.0
<br /><br />-Implemented New Query System! -Mike
	<br />--Results Now Display in a Pagination Form!!
	<br />--Can Be Paged Through And Sub-Searched Through!!

<br /><br />-Implemented BootStrap -Mike

<br /><br />-Added Various Libs/Functions To Project Folders -Mike

<br /><br />-Changed Limit on Query Returns to 4,000 -Mike
	<br />--Page Struggles to load when returning Too many results... 

<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************

<br /><br />4/29/15
<br />Group 7 IMDB V1.1
<br /><br />-Bug fixed, result links now lead to their current details page. -Mike

<br />-Query Actor/Director Name search Fixed/Improved! -Mike
<br />	--Now searches database using concatenated version of first and last name!
	
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************

<br /><br />4/29/2015
<br />Group 7 IMDB V2.0 -Mike

<br /><br />-Add New Layout To Pages! -Mike

<br /><br />More Containers, More Organization -Mike

<br /><br />-Navigation Bar Added! -Mike

<br /><br />-Logo Updated!!! -Mike

<br /><br />-New Home/Index Page. Will Serve As A "Splash" Page. -Mike

<br /><br />-Main Query Search updated to not expand out of container after results are processed. -Mike

<br /><br />-Added Custom CSS Sheet (My Own) -Mike

<br /><br />-Added Footer With Quick Links/CP Info -Mike

<br /><br />-Will Continue to Post Updates on this page from now on. -Mike


<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************

<br /><br />4/30/2015
<br />Group 7 IMDB V2.1

<br /><br />-Made Search Page Dynamically Increase As Columns Do -Mike

<br /><br />-Implemented Smarter Links For Returned Searches.  -Mike
<br />--Text Now Wraps and Will Not Expand out of Set Width for Columns.

<br /><br />-Added Catch To Make Sure Query Has Something in it before submitting. -Mike

<br /><br />-Capped Results From 4,000 Down To 1,000. -Mike

<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************

<br /><br />4/30/2015
<br />Group 7 IMDB V2.2
<br /><br />-SIGNIFICANTLY Reduced Code! Merged If's, Switches, etc. -Mike

<br /><br />-Code Is Now More Commented/Organized -Mike

<br /><br />-Removed Unnecessary CSS/Script Files. -Mike

<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************

<br /><br />4/30/2015
<br />Group 7 IMDB V3.0
<br /><br />-Dummy Pages For Top Rated ABC Has Been Implemented. -Mike

<br /><br />-Small Template/ Demo Layout Created For Top Pages. -Mike

<br /><br />-Updated All Links In Navbar, should all be going to correct places. -Mike

<br /><br />-Updated All Links In Footer, should all be going to correct places. -Mike

<br /><br />-Reformatted Home Page. NavBar Location Now Above Optical Center. -Mike

<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************

<br /><br />5/1/2015
<br />Group 7 IMDB V4.0
<br /><br />-Details Page Drastically Updated. -Mike

<br /><br />-Implemented Image Returns From Queries! -Mike

<br /><br />-Added 2 Klaric Pictures.... Nice? -Mike

<br /><br />-Pictures Are Now Formatted Depending If Width>Height or vice versa. -Mike

<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************

<br /><br />5/1/2015
<br />Group 7 IMDB V4.1 
<br /><br />-Small Tweeks To Details Image Results -Mike

<br /><br />-Added Demo Rating System For Movie Results!! (Appearance-Wise Only) -Mike

<br /><br />-Resized Picture/Rating Containers To Be More Appealing. -Mike


<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************

<br /><br />5/1/2015
<br />Group 7 IMDB V4.2
<br /><br />-Rating System (For Users) Has Been Implemented -Mike
<br /> --Please View userTable.userRatingsAndReviews for more info.

<br /><br />-Smart Rating System Catches Implemented -Mike
<br />--Users Can Only Rate One Movie, Once.
<br />--Users Can See What They Had Rated The Movie.
<br />--Users Must Be Logged On To Rate The Movie.

<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************
<br />*********************************************************************************************************************************************










<!-------------------------------------------------------------------------------------------------------------------------------->

<br /><br /><p style="color:blue;">KNOWN BUGS</p>
<br />[X]Session is tossing incorrect $id into details page. Is always tossing last one, may need to use html hidden tags instead.
		<br />--REVOLVED -Mike
<br /><br />-[]Table Glitches For a sec when returning more than 2,000 Records into Table Form.  -Mike
<br /><br />-[]Database is Filled With "Funky Data"... User Cannot Find Unless Searches For It's Keywords Though. -Mike
<br /><br />-[]Querried Pictures That Are Null Can Be Taken Care Of. Pictures That do Not Load Are not... -Mike


</p>
<div class = "container" style="width: 900px">
<img src="images/funky1.PNG" alt="funky1" style="float:left; width:400; height:400;">
<img src="images/funky2.PNG" alt="funky2" style="float:left; width:400; height:400;">
</div>

<p>Amazing Klaric Pics, lol</p>
<div class = "container" style="width: 900px">
<img src="images/klaric1.gif" alt="funky1" style="float:left; width:400; height:400;">
<img src="images/klaric2.gif" alt="funky2" style="float:left; width:400; height:400;">
</div>

<p>



</p>
</div> <!--Allign Left Content Container-->
</div> <!--End Body Container-->
</body>

<!--Footer-->
<div class="container" style="padding:0px 60px;">
	<footer class="clearfix">
		<div id="navbar" >
			<ul>
				<li><a href="index.php" >Home |</a></li>
				<li><a href="search.php">Search |</a></li>
				<li><a href="topTen.php?topPick=movie">Top Movies |</a></li>
				<li><a href="topTen.php?topPick=actor">Top Actors |</a></li>
				<li><a href="topTen.php?topPick=director">Top Directors |</a></li>
				<li><a href="information.php">Information |</a></li>
			</ul>
		&copy; 2015 CS3380 Group 7 <br />
		</div><!--Closes Navbar and Other Info laws-->
	</footer>
</div>									
</html>

