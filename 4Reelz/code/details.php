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
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">   
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<link rel="stylesheet" 
	href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
	<script type="text/javascript" 
	src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" 
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<link href="style.css" rel="stylesheet" type="text/css" />

	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
		<script src="http://malsup.github.com/jquery.form.js"></script> 
	
	
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	
	   <link rel="stylesheet"  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
    
	
	
	<!-- BREAKING CODE <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
   
<style>
	body{background-color:black;}


</style>


<!-- NEEDED -->   <script src="../js/star-rating.js" type="text/javascript"></script>
	<title>4Reelz Details</title>
</head>
<body>



<div id="loginPageContainer" style="height:auto;">
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
	
	<!-- <div style="width:800px; height: 400px; background-color:white; align:center; margin:auto; border-radius:6px; padding:20px;"> -->
<?php

	//Grab keys from index query
	
	$table = htmlspecialchars($_GET['table']);
	$switch = $_GET['switch'];


		if($switch == true)
		{
			$id = $_SESSION['id'];
			$switch = false; 				
		}
		else
		{
			$id = htmlspecialchars($_GET['id']);
		}

	
	function get_url_contents($url) 
	{
		$crl = curl_init();

		curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
		curl_setopt($crl, CURLOPT_URL, $url);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);

		$ret = curl_exec($crl);
		curl_close($crl);
		return $ret;
	}	
			switch($table)
			{	
				case movie: 	
						
						//Perform Query and set result equal to returned
						$result = pg_prepare($dbconn, 'my_query', "SELECT * FROM fourreelz.movie WHERE (id = $1)");
						$result = pg_execute($dbconn, 'my_query', array($id));
						$line = pg_fetch_array($result, null, PGSQL_ASSOC);
						
						//Grab Data From What was returned
						$id = $line['id'];
						$name = $line['name'];
						$year = $line['year'];
						
						//URL for OMDB pic
						//$omdbURL = $line[''];

						
						$result2 = pg_prepare($dbconn, 'omdb_query', "SELECT * FROM fourreelz.omdb WHERE title = $1 AND year = $2 LIMIT 1");
						$result2 = pg_execute($dbconn, 'omdb_query', array($name, $year));
						$line2 = pg_fetch_array($result2, null, PGSQL_ASSOC);
					
						//Use $line2 For Depictions and URLS										
					
						$omdbURL = $line2['poster'];
						$fullPlot = $line2['fullplot'];
						$shortPlot = $line2['plot'];

						if($fullPlot == null || $fullPlot == "")
						{
							$printPlot = $shortPlot;
						}
						else
						{
							$printPlot = $fullPlot;
						}
						if($printPlot == null || $printPlot == "")
						{
							$printPlot = 'Movie plot not available.';
						}

						//$currentRating = $line['rating'];
						
						$currentRating = $line['rating'] / 2;	
						//echo"CURRENT RATING IS: ". $currentRating;						
						$numberOfRatings = $line['numratings'];					
								

						if($name == null)
							$name = "N/A";
										
						if($year == null)
							$year = "N/A";
						
						echo"<div style='height:auto; width:660px; margin:0px auto 15px auto; background-color:white;border: solid black 4px;border-radius:10px;'>";
						echo"<h1 align = 'center'>$name</h1>";
						echo"</div>";
						

						$movieName = $name;
						$movieName = str_replace(' ', "", $movieName);
						
					
						if($omdbURL == null || $omdbURL == "")
						{	
							$json = get_url_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q='.$movieName.'+' . $year);

						}
						else
						{
							
							$json = get_url_contents($omdbURL);
						}
						$data = json_decode($json);

						foreach ($data->responseData->results as $result) 
						{
							$results[] = array('url' => $result->url, 'alt' => $result->title);
						}
						
						$counter = 0; 

						echo"<div style = 'width:980px; height: 500px;  margin:0px 0px 0px -15px;'>";
						if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
							{
									echo"<div style='height:auto; width:auto; border-radius:10px;float:left; margin:0px 0px 0px 40px;'>";
											echo"<img src='images/klaric1.gif' alt='funky1' style='float:left' width='420px' height='475px'>";
									echo"</div>";																						
							}					
							
						
						if($omdbURL == null || $omdbURL =="")
						{	//OLD
							foreach($results as $image):
							$counter++; 
							if($counter > 1) 
								break; 
										
							else
							{
									echo"<div style='height:auto; width:auto; float:left; margin:0px 0px 0px 50px;'>";
										?><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width='420px' height='475px' style='border-radius:6px;'/><br/><?php
									echo"</div>";																																
							}
	
								break;
							 endforeach; 	
						}
						else
						{
						echo"<div style='height:auto; width:auto; float:left; margin:0px 0px 0px 50px;'>";
				?><img src="<?php echo "".$omdbURL; ?>" alt="<?php echo $image['alt']; ?>" width='420px' height='475px' style='border-radius:6px;'/><br/><?php
						echo"</div>";	
						}
							

						
						
						
							?><div class='panel panel-default panel-danger' style = 'height:330px; width:435px; float:right;background-color:white; border-radius:10px; padding:5px; margin:0px 40px 0px 0px;'>
									<div class='panel-heading'>
										<h1 class='panel-title'>Rating Listing | Rated <?php echo''.round($currentRating,2); ?> Out of 5 Hearts by <?php echo''.$numberOfRatings; ?> Users!</h1>
									</div>
									<div class='panel-body'>		
									
									
									<form method="POST" action="<?php echo"details.php?id=$id&table=movie"; ?>"> 

										<input id="input-2b" name = "userRating"value = "<?php echo''.round($currentRating,2); ?> "type="3" class="rating" min="0" max="5" step="0.5" data-size="xl"
										data-symbol="&#xe005;" data-default-caption="{rating} hearts" data-star-captions="{}">

										<hr>


										<button style = "float:right;margin:-90px 0px 0px 0px"type="submit" name = "ratingSubmit" class="btn btn-primary">Submit</button>
									
									</form>

									<?php 
									
									$hasRated = false;
									$userStoredRating = 0;
									
									//Pull User's Records to display information
									$sql = "SELECT * FROM userTables.userRatings AS info WHERE (info.username = $1) AND (info.id = $2)";
									pg_prepare($dbconn, 'check_ranks', $sql);
									$resultRating = pg_execute($dbconn, 'check_ranks', array($username, $id)) or die("Error while Checking User Ranks In.");	
									
									
									$ratingRows = pg_num_rows($resultRating);
									
									if($ratingRows == 0)
									{
										$hasRated = false;
									}
									
									else
									{	$hasRated = true;
								
										while ($ratingInfo = pg_fetch_array($resultRating, null, PGSQL_ASSOC)) 
										{	
											$userStoredRating = $ratingInfo['rating'];
										
										}
									}
									
									
									
									
										if(isset($_SESSION['username']) && $hasRated == true)
										{
												
											echo"<p style='color:red; margin: -40px 0px 0px 0px;'>You Gave This Movie A Rating Of: ". $userStoredRating/2 .". You Can Only Rate Once.</p>";	

										}
										if(isset($_POST['ratingSubmit']))
										{
											if(!isset($_SESSION['username']))
											{
												echo"<p style='color:red; margin: -40px 0px 0px 0px;'>You Must Be Logged In To Submit A Rating </p>";	

											}
											
											else if (isset($_SESSION['username']) && $hasRated == false)
											{	
												$submittedRating = $_POST['userRating'] * 2;
												//$submittedRating = $_POST['userRating'];
												$action = "Rated A Movie";
												
												//Insert
												if($submittedRating == null || $submittedRating =="")
												{
													echo"Please Choose A Rating Before Sumbmitted it!";
												}
													
												else
												{
													$sql = "INSERT INTO userTables.userRatings(username, id, rating, action) VALUES($1, $2, $3, $4)";
												pg_prepare($dbconn, 'insert_rating', $sql);
												$resultRating = pg_execute($dbconn, 'insert_rating', array($username, $id, $submittedRating, $action)) or die("Error while Inserting.");	
												$resultRating = pg_fetch_array($resultRating, null, PGSQL_ASSOC);
									
												
													
												}
											
												
									
												$sql = "UPDATE fourreelz.movie SET rating = $1 where id = $2";
												pg_prepare($dbconn, 'update_rating', $sql);
												$resultMovieRating = pg_execute($dbconn, 'update_rating', array($submittedRating, $id)) or die("Error while Inserting Into Main Movie Table.");	
												$resultMovieRating = pg_fetch_array($resultMovieRating, null, PGSQL_ASSOC);						
									
												$switch = true;
												$_SESSION['id'] = $id;
												echo "<meta http-equiv='refresh' content='0;url=details.php?id=$id&table=$table&switch=true'>";
									
											?>

												<?php 
			
												$hasRated = true;
												echo"<p style='color:red; margin: -40px 0px 0px 0px;'>You Submitted A Rating of : " . $submittedRating/2 . "</p>";	
											}
										}
										?>


									</div>
								
							</div>
							
							<div style = 'height:100px; width:435px; float:right;background-color:white; border-radius:10px; padding:5px; margin:15px 40px 0px 0px;'>
							
							<?php
							
						
							
							
							$sql71 = "SELECT d.fname, d.lname, d.id FROM fourreelz.directors as d
							INNER JOIN fourreelz.movie_directors as md ON d.id = md.did
							INNER JOIN fourreelz.movie as m ON m.id = md.mid
							WHERE m.id = $1 LIMIT 1";
							
							pg_prepare($dbconn, 'check_relevant71', $sql71);
							$relevantMovies71 = pg_execute($dbconn, 'check_relevant71', array($id)) or die("Error With Query!");	
								
								
								
							//Grab Number of Records, or Rows, That Are present in Resulting Query
							$rows = pg_num_rows($relevantMovies71);
							if($rows == 0)
							{
								echo"<p text-align = 'center'>There Were No Directors Found For This Movie.<br /></p>\n";
							}
							else 
							{
								
							echo"<p style='text-align: center;  font-size: 1.4em; margin: -2px 0px 0px 0px;'>Top <i>$rows</i> Directors For This Movie <br /><br /></p>\n";
							
										
							while ($dirmovieee = pg_fetch_array($relevantMovies71, null, PGSQL_ASSOC)) 
							{
								$dirfname = $dirmovieee['fname'];
								$dirlame = $dirmovieee['lname'];
								$did = $dirmovieee['id'];
								
								$fullname = "$dirfname $dirlame"; 

								echo"\t\t\t<form id='movie_id_form2' method='POST' action=\"details.php?id=$did&table=directors\">\n";
								echo"<div style='text-align:center; magin: 0px 0px 0px 0px;' >";
									echo"\t\t\t<input type='submit' style='margin: 0px 0px 40px 0px; border: solid black 3px; border-radius: 12px; text-align:center; width:300px;white-space:normal; background-color:pink;' value='$fullname' onclick=\"details.php?id=$did&table=directors;\" />\n";
								echo"</div>";
								echo"\t\t\t</form>\n\n";

								
							}						
							}
							
							
							?>
							
							
							</div>
							
							
						</div>
							<?php
						echo"<div style='height:auto; width:870px; clear:both;  border: solid black 6px;background-color:white;border-radius:6px; margin: auto; padding:20px'>";
							echo"<h1 align = 'center'>Movie Details</h1>";
							
		
							echo nl2br("\nYear Released: " . $year);
							echo nl2br("\n\nPlot: " .$printPlot); ?> <br /> <?php
							
							//////////////////////////////////////////////////////
							
						
							
							
							$sql69 = "SELECT a.fname, a.lname, c.role, a.id FROM fourreelz.actor as a
								INNER JOIN fourreelz.casts as c ON a.id = c.pid
								INNER JOIN fourreelz.movie as m ON m.id = c.mid
								WHERE m.id = $1";
							pg_prepare($dbconn, 'check_relevant69', $sql69);
							$relevantMovies69 = pg_execute($dbconn, 'check_relevant69', array($id)) or die("Error With Query!");	
							?><br /><?php
						
							//Grab Number of Records, or Rows, That Are present in Resulting Query
							$rows = pg_num_rows($relevantMovies69);
							if($rows == 0)
							{
								echo"There Were No Results Returned.<br />\n";
							}
							
						
							
							else 
							{
								
								echo"There Were <i>$rows</i> Actors Casted Returned \n"; ?><br /><br /> <?php
								
								//As well as fields
								$num_field = pg_num_fields($returnedMoviesQuery);
								
								
								//Create Table/Table Headers A.K.A. Field Names
								echo "<table id='myTable' border = '1' class='table table-striped table-bordered table-condensed'>";
								echo"<thead>";
									echo "\t<tr>\n";
									echo "\t\t<th>Actor First Name</th>\n";
									echo "\t\t<th>Last Name</th>\n";
									echo "\t\t<th>Role</th>\n";
									//echo "\t\t<th>Director</th>\n";
									echo "\t</tr>\n";
								echo"</thead>";
								echo"<tbody>";					
								
								while ($movieList = pg_fetch_array($relevantMovies69, null, PGSQL_ASSOC)) 
								{				

									
									$fname = addslashes(htmlspecialchars($movieList['fname'], ENT_QUOTES, 'UTF-8'));
									$lname = addslashes(htmlspecialchars($movieList['lname'], ENT_QUOTES, 'UTF-8'));
									$role = addslashes(htmlspecialchars($movieList['role'], ENT_QUOTES, 'UTF-8'));
									$id3 = $movieList['id'];
									
									
										
									if($fname == null)
										$fname = "N/A";
												
									if($lname == null)
										$lname = "N/A";
		
									if($role == null)
										$role = "N/A";
									
									echo "\t<tr>\n";
									echo"<td>";
									
									echo"<p hidden>$fname</p>";
									echo"\t\t\t<form id='moviiieeee' method='POST' action=\"details.php?id=$id3&table=actor\">\n";
						
									echo"\t\t\t<input type='submit' style='width:300px;white-space: normal;' value='$fname' onclick=\"'details.php?id=$id3&table=actor';\" />\n";
									echo"\t\t\t</form>\n\n";							
									echo"</td>";

								
									echo "\t\t<td> ".$lname." </td>\n";
									echo "\t\t<td> ".$role." </td>\n";
									//echo "\t\t<td> ".$id." </td>\n";
									echo "\t</tr>\n";										
								}
									
								echo"</tbody>";
								echo "</table>\n";	
								echo"
								<script>
								$(document).ready(function(){
									$('#myTable').dataTable();
								});
								</script>";	
	
							}
							
							//////////////////////////////////////////////
							
	
						echo"</div>";
							
									
						break;
				
				case actor: 						
				
						//Perform Query and set result equal to returned
						$result = pg_prepare($dbconn, 'my_query', "SELECT * FROM fourreelz.actor WHERE (id = $1)");
						$result = pg_execute($dbconn, 'my_query', array($id));
						$line = pg_fetch_array($result, null, PGSQL_ASSOC);
						
						//Grab Data From What was returned
						$id = $line['id'];
						$fname = $line['fname'];
						$lname = $line['lname'];
						$gender = $line['gender'];

						if($fname == null)
							$fname = "N/A";
						
						if($lname == null)
							$lname = "N/A";
																		
						if($gender == null)
							$gender = "N/A";

						if($gender == 'M')
							$gender = "Male";						
						
						if($gender == 'F')
							$gender = "Female";						

						
						
						$result2 = pg_prepare($dbconn, 'omdb_query', "SELECT * FROM fourreelz.omdb WHERE title = $1 AND year = $2 LIMIT 1");
						$result2 = pg_execute($dbconn, 'omdb_query', array($name, $year));
						$line2 = pg_fetch_array($result2, null, PGSQL_ASSOC);
					
						//Use $line2 For Depictions and URLS										
						print_r($line2);
						$omdbURL = $line2['poster'];

						$currentRating = $line['rating'];
						//$currentRating = $line['rating'] / 2;			
						$numberOfRatings = $line['numratings'];
				


						
						echo"<div style='height:auto; width:660px; margin:0px auto 15px auto; background-color:white;border: solid black 4px;border-radius:10px;'>";
						echo"<h1 align = 'center'>$lname, $fname</h1>";
						echo"</div>";
						
						
					
						$fname = str_replace(' ', "", $fname);
						$fname = str_replace('.', "", $fname);
						$fname = str_replace(',', "", $fname);
						
						$lname = str_replace(' ', "", $lname);
						$lname = str_replace('.', "", $lname);
						$lname = str_replace(',', "", $lname);		
						
						
					
						if($omdbURL == null || $omdbURL == "")
						{	
							$json = get_url_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q='.$fname.'+' . $lname);

						}
						else
						{
						
							$json = get_url_contents($omdbURL);
						}
						$data = json_decode($json);

						foreach ($data->responseData->results as $result) 
						{
							$results[] = array('url' => $result->url, 'alt' => $result->title);
						}
						
						$counter = 0; 

						echo"<div style = 'width:980px; height: 500px;  margin:0px 0px 0px -15px;'>";
							if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
							{
									echo"<div style='height:auto; width:auto; border-radius:10px;float:left; margin:0px 0px 0px 40px;'>";
											echo"<img src='images/klaric1.gif' alt='funky1' style='float:left' width='420px' height='475px'>";
									echo"</div>";																						
							}					
							
						
						if($omdbURL == null || $omdbURL =="")
						{	//OLD
							foreach($results as $image):
							$counter++; 
							if($counter > 1) 
								break; 
										
							else
							{
									echo"<div style='height:auto; align: center; width:420px; margin:auto; '>";
										?><img align='middle' src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width='420px' height='475px' style='border-radius:6px; margin:0px auto; align:center;'/><br/><?php
									echo"</div>";																																
							}
	
								break;
							 endforeach; 	
						}
						else
						{
						echo"<div style='height:auto; width:auto; float:left; margin:0px 0px 0px 50px;'>";
				?><img src="<?php echo "".$omdbURL; ?>" alt="<?php echo $image['alt']; ?>" width='420px' height='475px' style='border-radius:6px;'/><br/><?php
						echo"</div>";	
						}
							

						
						
						
							?>
						</div>
							<?php
						echo"<div style='height:auto; width:870px; clear:both;  background-color:white;border-radius:6px; margin: auto; padding:20px'>";

							echo nl2br("Gender: " . $gender);
							
							
							
							$sql33 = "SELECT m.name, c.role, m.id FROM fourreelz.movie as m
							INNER JOIN fourreelz.casts as c ON m.id = c.mid
							INNER JOIN fourreelz.actor as a ON a.id = c.pid
							WHERE a.id = $1 ORDER BY m.numratings ASC";
								
								
							pg_prepare($dbconn, 'check_relevant', $sql33);
							$relevantMovies = pg_execute($dbconn, 'check_relevant', array($id)) or die("Error With Query!");	
							
						
							//Grab Number of Records, or Rows, That Are present in Resulting Query
							$rows = pg_num_rows($relevantMovies);
							if($rows == 0)
							{
								echo"There Were No Results Returned.<br />\n";
							}
	
							else 
							{
							
							
								?><br /><?php
								echo"<p>This Actors Has Been In <i>$rows</i> Movies.<br /></p>\n";
								//Create Table/Table Headers A.K.A. Field Names
								echo "<table id='myTable' border = '1' class='table table-striped table-bordered table-condensed'>";
								echo"<thead>";
									echo "\t<tr>\n";
									echo "\t\t<th>Movie Name</th>\n";
									echo "\t\t<th>Actor Role</th>\n";
									echo "\t</tr>\n";
								echo"</thead>";
								echo"<tbody>";					
								
							
								while ($relevantMoviesRow = pg_fetch_array($relevantMovies, null, PGSQL_ASSOC)) 
								{				
									$name = addslashes(htmlspecialchars($relevantMoviesRow['name'], ENT_QUOTES, 'UTF-8'));
									$role = $relevantMoviesRow['role'];
									$id2 = $relevantMoviesRow['id'];			
										
									if($name == null)
										$name = "N/A";
												
									if($role == null)
										$role = "N/A";
									
									echo "\t<tr>\n";
									echo"<td>";
									
									echo"<p hidden>$fname</p>";
									echo"\t\t\t<form id='movie_id_form2' method='POST' action=\"details.php?id=$id2&table=movie\">\n";
									echo"\t\t\t<input type='submit' style='width:300px;white-space: normal;' value='$name' onclick=\"details.php?id=$id2&table=movie;\" />\n";
									echo"\t\t\t</form>\n\n";							
									echo"</td>";

									echo "\t\t<td> ".$role." </td>\n";
									echo "\t</tr>\n";										
								}
							
								
									
								echo"</tbody>";
								echo "</table>\n";	
								echo"
								<script>
								$(document).ready(function(){
									$('#myTable').dataTable();
								});
								</script>";								
							}								
							
			
							
							
							
						echo"</div>";			
						break;
								
				case directors:	
				
						//Perform Query and set result equal to returned
						$result = pg_prepare($dbconn, 'my_query', "SELECT * FROM fourreelz.directors WHERE (id = $1)");
						$result = pg_execute($dbconn, 'my_query', array($id));
						$line = pg_fetch_array($result, null, PGSQL_ASSOC);
						
						//Grab Data From What was returned
						$id = $line['id'];
						$fname = $line['fname'];
						$lname = $line['lname'];
						
						if($fname == null)
							$fname = "N/A";
						
						if($lname == null)
							$lname = "N/A";
																		
						if($gender == null)
							$gender = "N/A";
						
						if($gender == 'M')
							$gender = "Male";						
						
						if($gender == 'F')
							$gender = "Female";						
						
						//URL for OMDB pic
						//$omdbURL = $line[''];
						
						
						$result2 = pg_prepare($dbconn, 'omdb_query', "SELECT * FROM fourreelz.omdb WHERE title = $1 AND year = $2 LIMIT 1");
						$result2 = pg_execute($dbconn, 'omdb_query', array($name, $year));
						$line2 = pg_fetch_array($result2, null, PGSQL_ASSOC);
					
						//Use $line2 For Depictions and URLS										

						$omdbURL = $line2['poster'];

						$currentRating = $line['rating'];

						//$currentRating = $line['rating'] / 2;			
						$numberOfRatings = $line['numratings'];
				


						
						echo"<div style='height:auto; width:660px; margin:0px auto 15px auto; background-color:white;border: solid black 4px;border-radius:10px;'>";
						echo"<h1 align = 'center'>$lname, $fname</h1>";
						echo"</div>";
						

						$fname = str_replace(' ', "", $fname);
						$fname = str_replace('.', "", $fname);
						$fname = str_replace(',', "", $fname);
						
						$lname = str_replace(' ', "", $lname);
						$lname = str_replace('.', "", $lname);
						$lname = str_replace(',', "", $lname);		
						
						
						
						if($omdbURL == null || $omdbURL == "")
						{	
							$json = get_url_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q='.$fname.'+' . $lname);

						}
						else
						{
							
							$json = get_url_contents($omdbURL);
						}
						$data = json_decode($json);

						foreach ($data->responseData->results as $result) 
						{
							$results[] = array('url' => $result->url, 'alt' => $result->title);
						}
						
						$counter = 0; 

						echo"<div style = 'width:980px; height: 500px;  margin:0px 0px 0px -15px;'>";
							if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
							{
									echo"<div style='height:auto; width:auto; border-radius:10px;float:left; margin:0px 0px 0px 40px;'>";
											echo"<img src='images/klaric1.gif' alt='funky1' style='float:left' width='420px' height='475px'>";
									echo"</div>";																						
							}					
							
						
						if($omdbURL == null || $omdbURL =="")
						{	//OLD
							foreach($results as $image):
							$counter++; 
							if($counter > 1) 
								break; 
										
							else
							{
									echo"<div style='height:auto; align: center; width:420px; margin:auto; '>";
										?><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width='420px' height='475px' style='border-radius:6px;'/><br/><?php
									echo"</div>";																																
							}
	
								break;
							 endforeach; 	
						}
						else
						{
						echo"<div style='height:auto; width:auto; float:left; margin:0px 0px 0px 50px;'>";
				?><img src="<?php echo "".$omdbURL; ?>" alt="<?php echo $image['alt']; ?>" width='420px' height='475px' style='border-radius:6px;'/><br/><?php
						echo"</div>";	
						}
							echo"</div>";	

						
						
						
							?>
							
							<?php
						echo"<div style='height:auto; width:870px; background-color:white;border-radius:6px; margin: auto; padding:20px'>";
							echo"<h1 align = 'center'>Director Details</h1>";

							echo nl2br("\nGender: " . $gender); ?> <br /><br /> <?php
							
							
							$sql366 = "SELECT m.name, m.year, m.id FROM fourreelz.movie as m
							INNER JOIN fourreelz.movie_directors as md on m.id = md.mid
							INNER JOIN fourreelz.directors as d on d.id = md.did
							WHERE d.id = $1
							ORDER BY m.year DESC";
								
								
							pg_prepare($dbconn, 'relevant_directorsssz', $sql366);
							$relevantDirectors = pg_execute($dbconn, 'relevant_directorsssz', array($id)) or die("Error With Query!");	
							
						
							//Grab Number of Records, or Rows, That Are present in Resulting Query
							$rows = pg_num_rows($relevantDirectors);
							if($rows == 0)
							{
								echo"There Were No Results Returned.<br />\n";
							}
	
							else 
							{
							
							
							
								echo"Directed <i> $rows </i> Movies";
							
								//Create Table/Table Headers A.K.A. Field Names
								echo "<table id='myTable' border = '1' class='table table-striped table-bordered table-condensed'>";
								echo"<thead>";
									echo "\t<tr>\n";
									echo "\t\t<th>Movie Name</th>\n";
									echo "\t\t<th>Year Released</th>\n";
									echo "\t</tr>\n";
								echo"</thead>";
								echo"<tbody>";					
								
							
								while ($relevantDirectorsRow = pg_fetch_array($relevantDirectors, null, PGSQL_ASSOC)) 
								{				
									$name = addslashes(htmlspecialchars($relevantDirectorsRow['name'], ENT_QUOTES, 'UTF-8'));
									$year = $relevantDirectorsRow['year'];
									$id2 = $relevantDirectorsRow['id'];			
										
									if($name == null)
										$name = "N/A";
												
									if($role == null)
										$role = "N/A";
									
									echo "\t<tr>\n";
									echo"<td>";
									
									echo"<p hidden>$name</p>";
									echo"\t\t\t<form id='movie_id_form2' method='POST' action=\"details.php?id=$id2&table=movie\">\n";
									echo"\t\t\t<input type='submit' style='width:300px;white-space: normal;' value='$name' onclick=\"details.php?id=$id2&table=movie;\" />\n";
									echo"\t\t\t</form>\n\n";							
									echo"</td>";

									echo "\t\t<td> ".$year." </td>\n";
									echo "\t</tr>\n";										
								}
							
									
								echo"</tbody>";
								echo "</table>\n";	
								echo"
								<script>
								$(document).ready(function(){
									$('#myTable').dataTable();
								});
								</script>";								
							}										
							
							
							
							
						echo"</div>";				
						break;
								
			}			
			

			
		
			
		echo"<div style='height:auto; margin:50px auto auto 40px; background-color:white;border-radius:6px; border: solid black 4px; padding:30px;'>";
						echo"<h1 align = 'center'>Comments/Reviews~</h1>";
						echo"<h3 align = 'center'>Submit Your Own Review/Comment</h3>";	

						echo"\t\t\t<form id='movie_id_form' method='POST' action=\"details.php?id=$id&table=$table\">\n";
						echo"<div style='margin:auto;border:solid white 6px; width:420px;'><textarea text-align='center' name = 'userReviewText' rows='5' cols='55' maxlength='250'></textarea>";				
						echo"<input align='center' style='float: right; margin:auto;'type='submit' name='commentSubmit' value='Submit' /></div> ";
						echo"</form> ";

	
						
						
						if(isset($_POST['commentSubmit']))
						{
							
							$action = "Commented On A Movie";
							$submittedReview = htmlspecialchars($_POST['userReviewText']);
							
							if(!isset($_SESSION['username']))
							{
								echo"<p style='color:red; float:clear;margin: 0px 0px 0px 0px;'>You Must Be Logged In To Comment!</p>";	
							}

							
							else if(isset($_SESSION['username']))
							{	
								if($submittedReview == "" || $submittedReview == null || $submittedReview == " ")
								{
									echo"<p style='color:red; float:clear;margin: 0px 0px 0px 0px;'>Please Enter A Valid Review.</p>";	
								}
						
								else
								{								
									//Insert
									$timestamp = date("F j, Y, g:i a"); 
									echo "$timestamp ";
									$sql = "INSERT INTO userTables.userReviews(username, id, review, log_date, action) VALUES($1, $2, $3, $4, $5)";
									$resultReview = pg_prepare($dbconn, 'insert_comment', $sql);
									$resultReview = pg_execute($dbconn, 'insert_comment', array($username, $id, $submittedReview, $timestamp, $action));
									
									if($resultReview == null)
									{
										echo"<p style='color:red; float:clear;margin: 0px 0px 0px 0px;'Error While Inserting.</p>";	

									}
									
									else
									{
										echo"<p style='color:red; float:clear;margin: 0px 0px 0px 0px;'>Thank You For Your Review.</p>";	
									}
								}
								
							}				
						}
		echo"</div>";
		
		
		echo"<div style='height:auto; width:700px; '>";	
		//Perform Query and set result equal to returned
		$resultReviews = pg_prepare($dbconn, 'reviews', "SELECT * FROM userTables.userReviews WHERE (id = $1) ORDER BY log_date DESC");
		$resultReviews = pg_execute($dbconn, 'reviews', array($id));
		$rowsForReviews = pg_fetch_array($result, null, PGSQL_ASSOC);
		
		while ($rowsForReviews = pg_fetch_array($resultReviews, null, PGSQL_ASSOC)) 
		{	
				$userReview = $rowsForReviews['review'];
				$userReviewName = $rowsForReviews['username'];
				$timePosted = $rowsForReviews['log_date'];
						
				$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
				$color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
    
						

				echo"<div class='panel panel-default panel-danger' style = ' height:auto; width:auto; float:left;  background-color:white; border: solid black 4px; border-radius:10px; padding:5px; margin:15px 0px 15px 40px;'>
																	
									<div class='panel-heading' style='background-color:$color;'>
										<h1 class='panel-title' style='color:white;'>$userReviewName Commented: ($timePosted)</h1>
									</div>
									<div class='panel-body'>												
										<p align = 'left'>$userReview</p>										
									</div>
						</div>";
							
							
							
							
							
				
										
		}
		
	
			


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
<!--End Body Container-->
</body>

</div>
<!--Footer-->
<div class="container" style="margin: 0px 0px -140px -120px; padding:0px 60px;clear:both;">
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

		










