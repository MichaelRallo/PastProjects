<!-- https://babbage.cs.missouri.edu/~cs3380s15grp7/imdb/index.php -->
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
    
	
	<title>4ReelzTop Ten</title>
</head>


<style>
	body{background-color:black;}


</style>
<body>


<div id="loginPageContainer" style='height:auto;'>
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


	
	<div style="width:800px; height: 400px; background-color:white; align:center; margin:auto; border-radius:6px; padding:20px; height:auto;">
<?php

	
	//Grab keys from index query
	$topPick = htmlspecialchars($_GET['topPick']);
	
	
	
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
	

	
	
	
			switch($topPick)
			{	
				case movie: 
				
				$table = 'movie';
				echo"<h1 align = 'center'>Top 10 Overall Movies:</h1>";
		
				
			//Pull User's Records to display information
			$sql3333 = "SELECT * FROM fourreelz.movie WHERE numratings > 10000 ORDER BY rating DESC LIMIT 10";
			
			
			
			pg_prepare($dbconn, 'movie_top', $sql3333);
			$topRating = pg_execute($dbconn, 'movie_top', array()) or die("Error while Checking User Ranks In.");	
			
		
				
				echo"<div style='height:1550px;  padding: 20px 5px; margin:auto 0px auto -5px; width:770px; border: solid black 12px; border-radius:12px; background-color:purple;'>";
			
				
				////////////////////////////////////////////////////////////////////////////////////
				
				
			 $line = pg_fetch_array($topRating, null, PGSQL_ASSOC); $name = $line['name']; $year = $line['year']; 

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

				echo"<div style='align:center; margin:0px 0px 0px 0px; '>";
				echo"<div class='panel panel-default panel-danger' style='width:260px;margin:0px 3px 15px 235px; background-color:black;' >";
					echo"<div class='panel-heading'>";
					$id = $line['id'];
					echo"<a href='details.php?id=$id&table=$table'><h3 class='panel-title' style='color:black;'>#1 $name ($year) </h3></a>";
					echo"</div>";
					

				
			if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
			{	//Use Klaric Default
								
					echo"<div class='panel-body' style='width:260px; height:360px; float:center; background-image:url(images/klaric1.gif); background-color:black;  background-size: 100% 100%; '>";
					echo"</div>";
				echo"</div>";
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
									echo"<div class='panel-body' style='width:260px; height:360px; float:center; background-image:url($urll); background-color:black;  background-size: 100% 100%; '>";									
									echo"</div>";
								echo"</div>";
								echo"</div>";										
							}
	
							break;
							endforeach; 	
			}					
	
			else
			{	//Use New Image
				echo"<div class='panel-body' style='width:260px; height:360px; float:center; background-image:url($omdbURL); background-color:black;  background-size: 100% 100%; '>";
				echo"</div>";
				echo"</div>";
				echo"</div>";	
			}	
			
						
	////////////////////////////////////////////////////////////////////////////////////
				 $line = pg_fetch_array($topRating, null, PGSQL_ASSOC); $name = $line['name']; $year = $line['year']; 

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
		
				echo"<div style='align:left; float:left; width:235px; height:340px; margin:0px 0px 20px 17px;' >";
					echo"<div style='padding: 6px; width: 230px;height:65px; color:white; background-color:black; margin: 0px 0px 0px 0px;'>";
							$id = $line['id'];
					echo"<a href='details.php?id=$id&table=$table' style='color:white'><h3 class='panel-title' style='color:white;'>#2 $name ($year) </h3></a>";					
					echo"</div>";
					

				
			if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
			{	//Use Klaric Default
								
					echo"<div  style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url(images/klaric1.gif); background-color:black;  background-size: 100% 100%; '>";
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
									echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($urll); background-color:black;  background-size: 100% 100%; '>";									
									echo"</div>";
															
							}
	
							break;
							endforeach; 	
			}					
	
			else
			{	//Use New Image
				echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($omdbURL); background-color:black;  background-size: 100% 100%; border: solid black 10px;'>";
				echo"</div>";

			}	
			
			echo"</div>";
						
	////////////////////////////////////////////////////////////////////////////////////
				 $line = pg_fetch_array($topRating, null, PGSQL_ASSOC); $name = $line['name']; $year = $line['year']; 

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
		
				echo"<div style='align:left; float:left; width:235px; height:340px; margin:0px 0px 20px 0px;' >";
					echo"<div style='padding: 6px; width: 230px;height:65px; color:white; background-color:black; margin: 0px 0px 0px 0px;'>";
					$id = $line['id'];
					echo"<a href='details.php?id=$id&table=$table' style='color:white'><h3 class='panel-title' style='color:white;'>#3 $name ($year) </h3></a>";					
					echo"</div>";
					

				
			if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
			{	//Use Klaric Default
								
					echo"<div  style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url(images/klaric1.gif); background-color:black;  background-size: 100% 100%; '>";
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
									echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($urll); background-color:black;  background-size: 100% 100%; '>";									
									echo"</div>";
															
							}
	
							break;
							endforeach; 	
			}					
	
			else
			{	//Use New Image
				echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($omdbURL); background-color:black;  background-size: 100% 100%; border: solid black 10px;'>";
				echo"</div>";

			}	
			
			echo"</div>";
						
	////////////////////////////////////////////////////////////////////////////////////
				 $line = pg_fetch_array($topRating, null, PGSQL_ASSOC); $name = $line['name']; $year = $line['year']; 

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
		
				echo"<div style='align:left; float:left; width:235px; height:340px; margin:0px 0px 20px 0px;' >";
					echo"<div style='padding: 6px; width: 230px;height:65px; color:white; background-color:black; margin: 0px 0px 0px 0px;'>";
										$id = $line['id'];
					echo"<a href='details.php?id=$id&table=$table' style='color:white'><h3 class='panel-title' style='color:white;'>#4 $name ($year) </h3></a>";					
					echo"</div>";
					

				
			if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
			{	//Use Klaric Default
								
					echo"<div  style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url(images/klaric1.gif); background-color:black;  background-size: 100% 100%; '>";
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
									echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($urll); background-color:black;  background-size: 100% 100%; '>";									
									echo"</div>";
															
							}
	
							break;
							endforeach; 	
			}					
	
			else
			{	//Use New Image
				echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($omdbURL); background-color:black;  background-size: 100% 100%; border: solid black 10px;'>";
				echo"</div>";

			}	
			
			echo"</div>";
						
	////////////////////////////////////////////////////////////////////////////////////
				 $line = pg_fetch_array($topRating, null, PGSQL_ASSOC); $name = $line['name']; $year = $line['year']; 

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
		
				echo"<div style='align:left; float:left; width:235px; height:340px; margin:0px 0px 20px 17px;' >";
					echo"<div style='padding: 6px; width: 230px;height:65px; color:white; background-color:black; margin: 0px 0px 0px 0px;'>";
									$id = $line['id'];
					echo"<a href='details.php?id=$id&table=$table' style='color:white'><h3 class='panel-title' style='color:white;'>#5 $name ($year) </h3></a>";					
					echo"</div>";
					

				
			if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
			{	//Use Klaric Default
								
					echo"<div  style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url(images/klaric1.gif); background-color:black;  background-size: 100% 100%; '>";
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
									echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($urll); background-color:black;  background-size: 100% 100%; '>";									
									echo"</div>";
															
							}
	
							break;
							endforeach; 	
			}					
	
			else
			{	//Use New Image
				echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($omdbURL); background-color:black;  background-size: 100% 100%; border: solid black 10px;'>";
				echo"</div>";

			}	
			
			echo"</div>";
						
	////////////////////////////////////////////////////////////////////////////////////
				 $line = pg_fetch_array($topRating, null, PGSQL_ASSOC); $name = $line['name']; $year = $line['year']; 

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
		
				echo"<div style='align:left; float:left; width:235px; height:340px; margin:0px 0px 20px 0px;' >";
					echo"<div style='padding: 6px; width: 230px;height:65px; color:white; background-color:black; margin: 0px 0px 0px 0px;'>";
										$id = $line['id'];
					echo"<a href='details.php?id=$id&table=$table' style='color:white'><h3 class='panel-title' style='color:white;'>#6 $name ($year) </h3></a>";					
					echo"</div>";;
					

				
			if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
			{	//Use Klaric Default
								
					echo"<div  style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url(images/klaric1.gif); background-color:black;  background-size: 100% 100%; '>";
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
									echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($urll); background-color:black;  background-size: 100% 100%; '>";									
									echo"</div>";
															
							}
	
							break;
							endforeach; 	
			}					
	
			else
			{	//Use New Image
				echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($omdbURL); background-color:black;  background-size: 100% 100%; border: solid black 10px;'>";
				echo"</div>";

			}	
			
			echo"</div>";
						
	////////////////////////////////////////////////////////////////////////////////////
				 $line = pg_fetch_array($topRating, null, PGSQL_ASSOC); $name = $line['name']; $year = $line['year']; 

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
		
				echo"<div style='align:left; float:left; width:235px; height:340px; margin:0px 0px 0px 0px;' >";
					echo"<div style='padding: 6px; width: 230px;height:65px; color:white; background-color:black; margin: 0px 0px 0px 0px;'>";
									$id = $line['id'];
					echo"<a href='details.php?id=$id&table=$table' style='color:white'><h3 class='panel-title' style='color:white;'>#7 $name ($year) </h3></a>";					
					echo"</div>";
					

				
			if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
			{	//Use Klaric Default
							echo"<p style='color:white;'></p>";
					echo"<div  style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url(images/klaric1.gif); background-color:black;  background-size: 100% 100%; '>";
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
									echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($urll); background-color:black;  background-size: 100% 100%; '>";									
									echo"</div>";
															
							}
	
							break;
							endforeach; 	
			}					
	
			else
			{	//Use New Image
				echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($omdbURL); background-color:black;  background-size: 100% 100%; border: solid black 10px;'>";
				echo"</div>";

			}	
			
			echo"</div>";
						
	////////////////////////////////////////////////////////////////////////////////////
			
		
				 $line = pg_fetch_array($topRating, null, PGSQL_ASSOC); $name = $line['name']; $year = $line['year']; 

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
		
				echo"<div style='align:left; float:left; width:235px; height:340px; margin:0px 0px 20px 17px;' >";
					echo"<div style='padding: 6px; width: 230px;height:65px; color:white; background-color:black; margin: 0px 0px 0px 0px;'>";
					$id = $line['id'];
					echo"<a href='details.php?id=$id&table=$table' style='color:white'><h3 class='panel-title' style='color:white;'>#8 $name ($year) </h3></a>";					
					echo"</div>";
					

				
			if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
			{	//Use Klaric Default
								
					echo"<div  style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url(images/klaric1.gif); background-color:black;  background-size: 100% 100%; '>";
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
									echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($urll); background-color:black;  background-size: 100% 100%; '>";									
									echo"</div>";
															
							}
	
							break;
							endforeach; 	
			}					
	
			else
			{	//Use New Image
				echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($omdbURL); background-color:black;  background-size: 100% 100%; border: solid black 10px;'>";
				echo"</div>";

			}	
			
			echo"</div>";
						
	////////////////////////////////////////////////////////////////////////////////////				
				
				
					 $line = pg_fetch_array($topRating, null, PGSQL_ASSOC); $name = $line['name']; $year = $line['year']; 

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
		
				echo"<div style='align:left; float:left; width:235px; height:340px; margin:0px 0px 20px 0px;' >";
					echo"<div style='padding: 6px; width: 230px;height:65px; color:white; background-color:black; margin: 0px 0px 0px 0px;'>";
					$id = $line['id'];
					echo"<a href='details.php?id=$id&table=$table' style='color:white'><h3 class='panel-title' style='color:white;'>#9 $name ($year) </h3></a>";					
					echo"</div>";
					

				
			if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
			{	//Use Klaric Default
								
					echo"<div  style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url(images/klaric1.gif); background-color:black;  background-size: 100% 100%; '>";
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
									echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($urll); background-color:black;  background-size: 100% 100%; '>";									
									echo"</div>";
															
							}
	
							break;
							endforeach; 	
			}					
	
			else
			{	//Use New Image
				echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($omdbURL); background-color:black;  background-size: 100% 100%; border: solid black 10px;'>";
				echo"</div>";

			}	
			
			echo"</div>";
						
	////////////////////////////////////////////////////////////////////////////////////
				 $line = pg_fetch_array($topRating, null, PGSQL_ASSOC); $name = $line['name']; $year = $line['year']; 

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
		
				echo"<div style='align:left; float:left; width:235px; height:340px; margin:0px 0px 0px 0px;' >";
					echo"<div style='padding: 6px; width: 230px;height:65px; color:white; background-color:black; margin: 0px 0px 0px 0px;'>";
					$id = $line['id'];
					echo"<a href='details.php?id=$id&table=$table' style='color:white'><h3 class='panel-title' style='color:white;'>#10 $name ($year) </h3></a>";					
					echo"</div>";
					

				
			if(($results == null || $results == "") && ($omdbURL == null || $omdbURL ==""))
			{	//Use Klaric Default
								
					echo"<div  style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url(images/klaric1.gif); background-color:black;  background-size: 100% 100%; '>";
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
									echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($urll); background-color:black;  background-size: 100% 100%; '>";									
									echo"</div>";
															
							}
	
							break;
							endforeach; 	
			}					
	
			else
			{	//Use New Image
				echo"<div style='margin: -15px 0px 0px 0px;width:230px; height:300px; background-image:url($omdbURL); background-color:black;  background-size: 100% 100%; border: solid black 10px;'>";
				echo"</div>";

			}	
			
			echo"</div>";
						
	////////////////////////////////////////////////////////////////////////////////////
			
				
				
			
				
				



				
		break;

				case actor:
				echo"<h1 align = 'center'>Top 10 Rated Actors:</h1>";
				
				$sql3667 = "SELECT a.fname, a.lname, a.id, count(c.pid) AS NoOfAppearances
				FROM userTables.userratings AS utsr
				LEFT JOIN fourreelz.movie AS m
				ON utsr.id = m.id
				LEFT JOIN fourreelz.casts AS c
				ON c.mid = m.id
				LEFT JOIN fourreelz.actor AS a
				on a.id = c.pid
				WHERE utsr.rating > 3.5
				GROUP BY a.fname, a.lname, c.pid,a.id
				ORDER BY NoOFAppearances DESC
				LIMIT 10";
												
								
						
							pg_prepare($dbconn, 'relevant_directorsssz33', $sql3667);
							$relevantDirectors = pg_execute($dbconn, 'relevant_directorsssz33', array()) or die("Error With Query!");	
							
						
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
									echo "\t\t<th>Rank</th>\n";
									echo "\t\t<th>Actor First Name</th>\n";
									echo "\t\t<th>Actor Last Name</th>\n";
									echo "\t</tr>\n";
								echo"</thead>";
								echo"<tbody>";					
								
								$counter = 1;
								while ($relevantDirectorsRow = pg_fetch_array($relevantDirectors, null, PGSQL_ASSOC)) 
								{		
							
									$fname = addslashes(htmlspecialchars($relevantDirectorsRow['fname'], ENT_QUOTES, 'UTF-8'));
									$lname = addslashes(htmlspecialchars($relevantDirectorsRow['lname'], ENT_QUOTES, 'UTF-8'));
									$id2 = $relevantDirectorsRow['id'];	
									
										
									if($name == null)
										$name = "N/A";
												
									if($role == null)
										$role = "N/A";
									
									echo "\t<tr>\n";
									echo "\t\t<td> ".$counter++." </td>\n";
									
									
									
									
									echo"<td>";
									echo"<p hidden>$name</p>";
									echo"\t\t\t<form id='movie_id_form2' method='POST' action=\"details.php?id=$id2&table=actor\">\n";
									echo"\t\t\t<input type='submit' style='width:300px;white-space: normal;' value='$fname' onclick=\"details.php?id=$id2&table=actor;\" />\n";
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
				echo"<h1 align = 'center'>Top 10 Rated Directors:</h1>";
				$sql3667 = "SELECT d.fname, d.lname, d.id, count(md.did) AS NoOfAppearances
					FROM userTables.userratings AS utsr
					LEFT JOIN fourreelz.movie AS m
					ON utsr.id = m.id
					LEFT JOIN fourreelz.movie_directors AS md
					ON md.mid = m.id
					LEFT JOIN fourreelz.directors AS d
					on md.did = d.id
					WHERE utsr.rating > 3.5
					GROUP BY d.fname, d.lname, md.did, d.id
					ORDER BY NoOFAppearances DESC
					LIMIT 10";
								
								
						
							pg_prepare($dbconn, 'relevant_directorsssz33', $sql3667);
							$relevantDirectors = pg_execute($dbconn, 'relevant_directorsssz33', array()) or die("Error With Query!");	
							
						
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
									echo "\t\t<th>Rank</th>\n";
									echo "\t\t<th>Director First Name</th>\n";
									echo "\t\t<th>Director Last Name</th>\n";
									echo "\t</tr>\n";
								echo"</thead>";
								echo"<tbody>";					
								
								$counter = 1;
								while ($relevantDirectorsRow = pg_fetch_array($relevantDirectors, null, PGSQL_ASSOC)) 
								{		
							
									$fname = addslashes(htmlspecialchars($relevantDirectorsRow['fname'], ENT_QUOTES, 'UTF-8'));
									$lname = addslashes(htmlspecialchars($relevantDirectorsRow['lname'], ENT_QUOTES, 'UTF-8'));
									$id2 = $relevantDirectorsRow['id'];	
									
										
									if($name == null)
										$name = "N/A";
												
									if($role == null)
										$role = "N/A";
									
									echo "\t<tr>\n";
									echo "\t\t<td> ".$counter++." </td>\n";
									
									
									
									
									echo"<td>";
									echo"<p hidden>$name</p>";
									echo"\t\t\t<form id='movie_id_form2' method='POST' action=\"details.php?id=$id2&table=directors\">\n";
									echo"\t\t\t<input type='submit' style='width:300px;white-space: normal;' value='$fname' onclick=\"details.php?id=$id2&table=directors;\" />\n";
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

				default : 		
				
						$table = null;
						header('Location: index.php');
						break;
			}			


	pg_close($dbconn);

	
?>
	</div>
	
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
	
	</div>
	
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

