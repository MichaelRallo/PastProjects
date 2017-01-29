<!-- https://babbage.cs.missouri.edu/~cs3380s15grp7/imdb/index.php -->
<!-- https://developers.google.com/image-search/v1/devguide#load_the_javascript_api_and_ajax_search_module -->
<!-- http://stackoverflow.com/questions/2157389/blog-post-comment-without-page-refresh-ajax -->

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
	
	
	  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
    <script src="http://malsup.github.com/jquery.form.js"></script> 
	
	
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">   
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<link rel="stylesheet" 
	href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
	<script type="text/javascript" 
	src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" 
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<link href="style.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	
	    <link rel="stylesheet"  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="../js/star-rating.js" type="text/javascript"></script>
	<title>Group 7 IMDB Top Ten</title>
</head>
<body>

<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">

<div id="loginPageContainer" style="height:auto;">
	<!--Header For Logo/Login/Logout/Register-->
	<div class="row" style="padding-top: 20px;opacity:.80;">
		<div class="col-xs-12 " >
			<div class="well" style = " background-image: url('images/headbg.gif');">
				<div align = "right">  
					<a href="index.php"> <img src="images/webLogo2.gif" alt="Logo" style="float:left; width:100px; height:80px; margin:-8px 0px"></a>

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
							
							echo"\n<p style='font-size:1.4em;color:WHITE;'>Logged In As: " . $user_info['username'] . "</p>";
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
	
	<!-- <div style="width:800px; height: 400px; background-color:white; align:center; margin:auto; border-radius:6px; padding:20px;"> -->
<?php

	//Grab keys from index query
	
		$id = 701589; 
		echo"ID is: ".$id;		
	
	
		$_SESSION['matchingID'] = $id;
		
	echo"



<form id='myForm' action='comment.php' method='post'> 
    Name: <input type='text' name='name' /> 
    Comment: <textarea name='comment'></textarea> 
    <input type='submit' value='Submit Comment' /> 
</form>
	
	
	
	";
	
	

			
		
			
		echo"<div style='height:300px; margin:50px auto auto 40px; background-color:white;border-radius:6px; padding:30px;'>";
						echo"<h1 align = 'center'>Comments/Reviews~</h1>";
						echo"<h3 align = 'left'>Submit Your Own Review/Comment</h3>";	

						if($submitted != true)
						{
							echo"\t\t\t<form id='movie_id_form' method='POST' action=\"details.php\">\n";
							echo"<textarea name = 'userReviewText' rows='5' cols='55' maxlength='250'></textarea> ";				
							echo"<input type='submit' name='commentSubmit' value='Submit' />";
							echo"\t\t\t<input type='hidden' name='id' value='$id' />\n";
							echo"</form> ";

						}
						
						else
						{						
							echo"\t\t\t<form id='movie_id_form' method='POST' action=\"details.php\">\n";
							echo"<textarea name = 'userReviewText' disabled='true' rows='5' cols='55' maxlength='250'></textarea> ";
							echo"\t\t\t<input type='hidden' name='id' value='$id' />\n";
							echo"<input type='submit' name='reSubmit' value='Comment Again!' />";
							echo"</form> ";
								
								
							$action = "Commented On A Movie";
					
							if($submittedReview == "" || $submittedReview == null || $submittedReview == " ")
							{
								echo"<p style='color:red; float:clear;margin: 0px 0px 0px 0px;'>Please Enter A Valid Review.'</p>";	
							}
							
							else if (isset($_SESSION['username']))
							{	
								
							
								$action = "Commented On A Movie";
								
								if($submittedReview == "" || $submittedReview == null || $submittedReview == " ")
								{
								echo"<p style='color:red; float:clear;margin: 0px 0px 0px 0px;'>Please Enter A Validddd Review.'</p>";	
								}
								
								else
								{				
								//Insert
								echo"<p style='color:red; float:clear;margin: 0px 0px 0px 0px;'>Prepping.'</p>";	

								$sql = "INSERT INTO userTables.userReviews(username, id, review, action) VALUES($1, $2, $3, $4)";
								$resultReview = pg_prepare($dbconn, 'insert_comment', $sql);
								$resultReview = pg_execute($dbconn, 'insert_comment', array($username, $id, $submittedReview, $action)) or die("Error while Inserting Comment.");	
					
								echo"<p style='color:red; float:clear;margin: 0px 0px 0px 0px;'>Thank You For Your Review.</p>";	
								
								}
								
							}
					
						}
					
		
			
		
		
			
			
		
		echo"</div>";
		
		
		
		echo"<div style='height:auto; width:700px; '>";	
		//Perform Query and set result equal to returned
		$resultReviews = pg_prepare($dbconn, 'reviews', "SELECT * FROM userTables.userReviews WHERE (id = $1)");
		$resultReviews = pg_execute($dbconn, 'reviews', array($id));
		$rowsForReviews = pg_fetch_array($result, null, PGSQL_ASSOC);
		
		while ($rowsForReviews = pg_fetch_array($resultReviews, null, PGSQL_ASSOC)) 
		{	
				$userReview = $rowsForReviews['review'];
				$userReviewName = $rowsForReviews['username'];
							
				echo"<div style='height:auto; padding: 20px; float: left; width:600px; margin:20px 60px 0px 20px; background-color:white;border-radius:6px;'>";
							echo"<p align = 'left'>" . $userReviewName . " Commented: " . $userReview . "</p>";	
				echo"</div>";
										
		}
		echo"<p style='clear:both; color:green;'>End Of Comments</p>";

		echo"</div>";
			

			
			
			
			

		pg_close($dbconn);

	
	
	
	
?>

<script>
    jQuery(document).ready(function () {
        $("#input-21f").rating({
            starCaptions: function(val) {
                if (val < 3) {
                    return val;
                } else {
                    return 'high';
                }
            },
            starCaptionClasses: function(val) {
                if (val < 3) {
                    return 'label label-danger';
                } else {
                    return 'label label-success';
                }
            },
            hoverOnClear: false
        });
        
        $('#rating-input').rating({
              min: 0,
              max: 5,
              step: 1,
              size: 'lg',
              showClear: false
           });
           
        $('#btn-rating-input').on('click', function() {
            $('#rating-input').rating('refresh', {
                showClear:true, 
                disabled:true
            });
        });
        
        
        $('.btn-danger').on('click', function() {
            $("#kartik").rating('destroy');
        });
        
        $('.btn-success').on('click', function() {
            $("#kartik").rating('create');
        });
        
        $('#rating-input').on('rating.change', function() {
            alert($('#rating-input').val());
        });
        
        
        $('.rb-rating').rating({'showCaption':true, 'stars':'3', 'min':'0', 'max':'3', 'step':'1', 'size':'xs', 'starCaptions': {0:'status:nix', 1:'status:wackelt', 2:'status:geht', 3:'status:laeuft'}});
    });
</script>

	<!--</div>-->
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

		










