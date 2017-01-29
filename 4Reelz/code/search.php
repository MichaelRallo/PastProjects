<!-- https://babbage.cs.missouri.edu/~cs3380s15grp7/imdb/index.php -->
<?php
	session_start();
	
	//Check if using secured https
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $redirect");
	}
	
	if(isset($_SESSION['table']))
		unset($_SESSION['table']);
	
	if(isset($_SESSION['id']))
		unset($_SESSION['id']);
	
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

	<title>4Reelz Search</title>
</head>
<body>


<div id="searchPageContainer" style="height:auto; background-color: #FFD6AD; background-repeat:no-repeat;">
	<!--Header For Logo/Login/Logout/Register-->
	<div class="row" style="padding-top: 20px;opacity:.80;">
		<div class="col-xs-12 " style = 'height:auto;'>
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
		
		
		<!--Extra/Recommended/Movie Genre? Area-->
			<div class="row">
			
				<!--Column For Extra/Recommended/Movie Genre? Area-->
				<div class="col-xs-3 "  >
					<div class="panel panel-default panel-danger" style = "height: auto; ">
						<div class="panel-heading"><h3 class="panel-title">Recommended Movies:</h3></div>
						<div class="panel-body">
							<?php
								if(isset($_SESSION['username']))
								{
									
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
	
                                		echo"<h3 align = 'center'>5 Recomended Movies For You:</h3>";
	

        	                					//Pull User's Records to display information
										$sql1212 = "SELECT g.genre, c.pid, count(c.pid) AS NoOfAppearances
												FROM userTables.userratings AS utsr
												LEFT JOIN fourreelz.genres AS g
												ON g.mid = utsr.id
												LEFT JOIN fourreelz.casts AS c
												ON g.mid = c.mid
												LEFT JOIN fourreelz.actor AS a
												ON a.id = c.pid
												WHERE utsr.rating > 3.5
												AND utsr.username = $1
												GROUP BY g.genre, c.pid
												ORDER BY NoOfAppearances DESC
												LIMIT 5";

										pg_prepare($dbconn, 'genre_top', $sql1212);
                                                                                $genresss = pg_execute($dbconn, 'genre_top', array('dustin')) or die("Error for genre_top.");
										$num=0;
										while($line3 = pg_fetch_array($genresss, null, PGSQL_ASSOC))
										{
											$sql33336 = "SELECT m.name,m.year,m.id FROM fourreelz.movie AS m
													INNER JOIN fourreelz.genres AS g
													ON m.id = g.mid
													INNER JOIN fourreelz.casts AS c
													ON m.id = c.mid 
													WHERE g.genre = $1
													AND m.name NOT IN (SELECT mv.name FROM fourreelz.movie AS mv
													LEFT OUTER JOIN userTables.userratings AS ut
													ON mv.id = ut.id
													WHERE ut.username = $2)
													AND c.pid = $3 
													ORDER BY RANDOM()
													LIMIT 1";
												
											$genre = $line3['genre'];
                                                                                    
										
											$actor = $line3['pid'];
											
											pg_prepare($dbconn, 'mov_top', $sql33336);
                                        	$movieeee = pg_execute($dbconn, 'mov_top', array($genre,$username,$actor)) or die("Error for mov_top.");
											

											
											
											
											//PUT TABLE HERE!
										

				 $line = pg_fetch_array($movieeee, null, PGSQL_ASSOC); $name = $line['name']; $year = $line['year']; 

				
				 
						$result2 = pg_prepare($dbconn, 'omdb_query', "SELECT * FROM fourreelz.omdb WHERE title = $1 AND year = $2 LIMIT 1");
						$result2 = pg_execute($dbconn, 'omdb_query', array($name, $year));
						$line2 = pg_fetch_array($result2, null, PGSQL_ASSOC);	
					
						
					
						$omdbURL = $line2['poster'];

						
						if($omdbURL == null || $omdbURL == "")
						{
							$json = get_url_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q='.str_replace(' ', "", $name).'+' . $year);
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
		

				$table = 'movie';
				
				echo"<div style='align:left; float:left; width:200px; height:340px; margin:0px 0px 20px -10px;' >";
					echo"<div style='padding: 6px; width: 200px;height:65px; color:white; background-color:black; margin: 0px 0px 0px 0px;'>";
							$id = $line['id'];
					echo"<a href='details.php?id=$id&table=$table' style='color:white'><h3 class='panel-title' style='color:white;'>$name ($year) </h3></a>";					
					echo"</div>";
					

				
			if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
			{	//Use Klaric Default
								
					echo"<div  style='margin: -15px 0px 0px 0px;width:200px; height:300px; background-image:url(images/klaric1.gif); background-color:black;  background-size: 100% 100%; '>";
					echo"</div>";
	
			}				
						
			if($omdbURL == null || $omdbURL =="")
			{	//Use Old Image
							foreach($results as $image):
							$counter++; 
							if($counter > 1) 
								break; 
										
							else
							{
							
									$urll = $image['url'];
									echo"<div style='margin: -15px 0px 0px 0px;width:200px; height:300px; background-image:url($urll); background-color:black;  background-size: 100% 100%; '>";									
									echo"</div>";
															
							}
	
							break;
							endforeach; 	
			}					
	
			else
			{	//Use New Image
				echo"<div style='margin: -15px 0px 0px 0px;width:200px; height:300px; background-image:url($omdbURL); background-color:black;  background-size: 100% 100%; border: solid black 10px;'>";
				echo"</div>";

			}	
			echo"</div>";
			
						
	////////////////////////////////////////////////////////////////////////////////////										
										
										
										
										
										
										
										
										
										
										
										
										
										
										
										
										
										
										
										
										
										
										
										
										
										
						

						
												
										}
						
								}
								else
								{
									echo'Please login to view Recommendations.';
								}
							?>
						</div>
					</div>	
				</div>
				
				<!--Column For Search/Query Area-->
				<div class="col-xs-9 ">
					<div class="panel panel-default panel-danger" style = "height: auto;">
						<div class="panel-heading"><h3 class="panel-title">Search For Your Favorite Movies, Actors, and Directors Here!</h3></div>
						<div class="panel-body">	

							
							<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
								<div style="margin-left: -5px; margin-bottom: 5px;"> 
								<input type="text"     name="search" id="search" placeholder="Enter what you wish to search" style="width:200px; margin: 0px 5px;">
							<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
							
							
							
							
							<div style="float:right; padding-right:0px">
							<p>Type Of Search:
							<select name="query" style="padding-right:100px;">
							</form>
							<?php 
								//Drop Down Menu... Keep Selection Selected After Search
								$lastSearchtype = $_POST["query"];
							
								//Movie Option
								echo"<option value='movie' ";
								if ($lastSearchtype=='movie' || $lastSearchtype == NULL) 
									echo "selected='selected' >"; 
								else
									echo ">"; 
								echo"Movie Title </option>\n";	
							
								//Actor Option
								echo"<option value='actor' ";
								if ($lastSearchtype=='actor') 
									echo "selected='selected' >"; 
								else
									echo ">"; 
								echo"Actor</option>\n";	
								
								//Director Option
								echo"<option value='director' ";
								if ($lastSearchtype=='director') 
									echo "selected='selected' >"; 
								else
									echo ">"; 
								echo"Director</option>\n";	
								
							?>
							</select>
							</p>
							</div>
								
								
								
								
								
								</div>
								<input type="submit" name="submit" value="Submit" />
							</form>
							
							
	
<?php
	//See if Query Was Submitted
	if(isset($_POST['submit']))
	{			
		//Grab User Input and Clean it
		$clean_user_input = htmlspecialchars($_POST['search']);
		
		if($clean_user_input == null || $clean_user_input == '')
		{
			echo"Please Enter A Valid Search.";
		}
		
		else
		{	
		//Set Result equal to suitable query
		switch(htmlspecialchars($_POST['query']))
		{
			case movie: 	
							echo"Searching Movies...\n";
							$result = pg_prepare($dbconn, "movie_lookup", "SELECT * FROM fourreelz.movie WHERE name ILIKE $1 ORDER BY name ASC LIMIT 1000");
							$result = pg_execute($dbconn, "movie_lookup", array("%".$clean_user_input."%")) or die("Error while Searching.");
							
							//Grab Number of Records, or Rows, That Are present in Resulting Query
							$rows = pg_num_rows($result);
							if($rows == 0)
							{
								echo"There Were No Results Returned.<br />\n";
							}
	
							else 
							{
								echo"Top <i>$rows</i> Results Returned <br /><br />\n";
								
								//As well as fields
								$num_field = pg_num_fields($result);
								
								
								//Create Table/Table Headers A.K.A. Field Names
								echo "<table id='myTable' border = '1' class='table table-striped table-bordered table-condensed'>";
								echo"<thead>";
									echo "\t<tr>\n";
									echo "\t\t<th>Movie Title</th>\n";
									echo "\t\t<th>Year Released</th>\n";
									echo "\t\t<th>Id</th>\n";
									echo "\t</tr>\n";
								echo"</thead>";
								echo"<tbody>";					
								
								while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
								{				

						
									$name = addslashes(htmlspecialchars($line['name'], ENT_QUOTES, 'UTF-8'));
									$year = $line['year'];
									$id = $line['id'];
									
										
									if($name == null)
										$name = "N/A";
												
									if($year == null)
										$year = "N/A";
									
									echo "\t<tr>\n";
									echo"<td>";
									
									echo"<p hidden>$name</p>";
									echo"\t\t\t<form id='movie_id_form' method='POST' action=\"details.php?id=$id&table=movie\">\n";
									echo"\t\t\t<input type='submit' style='width:300px;white-space: normal;' value='$name' onclick=\"'details.php?id=$id&table=movie';\" />\n";
									echo"\t\t\t</form>\n\n";							
									echo"</td>";

									echo "\t\t<td> ".$year." </td>\n";
									echo "\t\t<td> ".$id." </td>\n";
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
							
							break;
			
			case actor: 
							echo"Searching Actors...\n";
							$result = pg_prepare($dbconn, "actor_lookup", "SELECT * FROM fourreelz.actor WHERE CONCAT(fname, ' ', lname) ILIKE $1 OR fname ILIKE $1 OR lname ILIKE $1 ORDER BY lname ASC, fname ASC LIMIT 1000");
							$result = pg_execute($dbconn, "actor_lookup", array("%".$clean_user_input."%")) or die("Error while Searching.");	
							
							//Grab Number of Records, or Rows, That Are present in Resulting Query
							$rows = pg_num_rows($result);
							if($rows == 0)
							{
								echo"There Were No Results Returned.<br />\n";
							}

							else 
							{
								echo"Top <i>$rows</i> Results Returned <br /><br />\n";
								
								//As well as fields
								$num_field = pg_num_fields($result);							
								
								//Create Table/Table Headers A.K.A. Field Names
								echo "<table id='myTable' border = '1' class='table table-striped table-condensed'>";
								echo"<thead>";
									echo "\t<tr>\n";
									echo "\t\t<th>First Name</th>\n";
									echo "\t\t<th>Last Name</th>\n";
									echo "\t</tr>\n";
								echo"</thead>";
								echo"<tbody>";
								
								while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
								{
									
									
									$fname = addslashes(htmlspecialchars($line['fname'], ENT_QUOTES, 'UTF-8'));
									$lname = addslashes(htmlspecialchars($line['lname'], ENT_QUOTES, 'UTF-8'));
									$id = $line['id'];
									$_SESSION['id'] = $id;
									
									
									
									if($fname == null)
										$fname = "N/A";
									if($lname == null)
										$lname = "N/A";
											
									echo "\t<tr>\n";									
									echo"<td>";
									
									echo"<p hidden>$fname</p>";
									echo"\t\t\t<form id='movie_id_form' method='POST' action=\"details.php?id=$id&table=actor\">\n";
									echo"\t\t\t<input type='submit' value='$fname' onclick=\"'details.php?id=$id&table=actor';\" />\n";
									echo"\t\t\t</form>\n\n";							
									echo"</td>";
																	
									echo "\t\t<td> ".$lname." </td>\n";
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
							
							break;
			
			case director:	
							echo"Searching Directors...\n";
							$result = pg_prepare($dbconn, "director_lookup", "SELECT * FROM fourreelz.directors WHERE CONCAT(fname, ' ', lname) ILIKE $1 OR fname ILIKE $1 OR lname ILIKE $1 ORDER BY lname ASC, fname ASC LIMIT 1000");
							$result = pg_execute($dbconn, "director_lookup", array("%".$clean_user_input."%")) or die("Error while Searching.");		

							//Grab Number of Records, or Rows, That Are present in Resulting Query
							$rows = pg_num_rows($result);
							if($rows == 0)
							{
								echo"There Were No Results Returned.<br />\n";
							}
							
							else 
							{
								echo"Top <i>$rows</i> Results Returned <br /><br />\n";
								
								//As well as fields
								$num_field = pg_num_fields($result);
								
								
								//Create Table/Table Headers A.K.A. Field Names
								echo "<table id='myTable' border = '1' class='table table-striped table-condensed'>";
								echo"<thead>";
									echo "\t<tr>\n";
									echo "\t\t<th>First Name</th>\n";
									echo "\t\t<th>Last Name</th>\n";
									echo "\t</tr>\n";
								echo"</thead>";
								echo"<tbody>";
								
								while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
								{
									$fname = addslashes(htmlspecialchars($line['fname'], ENT_QUOTES, 'UTF-8'));
									$lname = addslashes(htmlspecialchars($line['lname'], ENT_QUOTES, 'UTF-8'));
									$id = $line['id'];
									$_SESSION['id'] = $id;
									
									if($fname == null)
										$fname = "N/A";
									if($lname == null)
										$lname = "N/A";
											
									echo "\t<tr>\n";							
									echo"<td>";
									
									echo"<p hidden>$fname</p>";
									echo"\t\t\t<form id='movie_id_form' method='POST' action=\"details.php?id=$id&table=directors\">\n";
									echo"\t\t\t<input type='submit' value='$fname' onclick=\"'details.php?id=$id&table=directors;\" />\n";
									echo"\t\t\t</form>\n\n";							
									echo"</td>";
									
									echo "\t\t<td> ".$lname." </td>\n";
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
		
							break;

			default : 		$table = null;
							echo"No Option Selected<br />";
							break;
			
		} //End Switch			
		} //End Else
			

			

	} //End If Isset
	
	// Free result set
	pg_free_result($result);
	pg_close($dbconn);
?>

</div>
					
					</div><!-- End Panel-->
				</div> <!--End Search/Query Column-->
			</div><!--End Row-->
							

	


	</div><!--End Body Container-->
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




		<!--ripped star fill code-->
	<!--	<style>
			.rating {
			  unicode-bidi: bidi-override;
			  direction: rtl;
			  text-align: center;
			}
			.rating > span {
			  display: inline-block;
			  position: relative;
			  width: 1.1em;
			}
			.rating > span:hover,
			.rating > span:hover ~ span {
			  color: transparent;
			}
			.rating > span:hover:before,
			.rating > span:hover ~ span:before {
			   content: "\2605";
			   position: absolute;
			   left: 0;
			   color: gold;
			}
		</style>-->
		
		
		

