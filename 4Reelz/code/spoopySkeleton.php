<!-- https://babbage.cs.missouri.edu/~cs3380s15grp7/imdb/spoopySkeleton.php -->
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

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<link rel="stylesheet" 
href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
<script type="text/javascript" 
src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" 
src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


<title>Group 7 IMDB</title>

        <style>
		
          body 
		 { 
			background-image: url("images/bg3.jpg");
			background-repeat: no-repeat;
			background-position: top;			
			padding-top: 50px;
			background-color: BLACK;
		 }

        </style>

<div class="wrapper">
<div class="container">
			<div class="row">
				<div class="col-xs-12 ">
					<div class="well">
						This is Where Logo/Login/Logout Will Go
					</div>
				</div>
			</div>


	<!--Nav Bar -->
		<div class="navbar navbar-default navbar-inverse" align = "center">
			<div class="container" align = "center">
				<div class="navbar-header" align = "center">
					<a href="index.php" class="navbar-brand" style="margin : 0px 20px 0px 40px;" >Search</a>
					<a href="index.php" class="navbar-brand" style="margin : 0px 20px 0px 40px;">Top Movies</a>
					<a href="index.php" class="navbar-brand" style="margin : 0px 20px 0px 40px;">Top Actors</a>
					<a href="index.php" class="navbar-brand" style="margin : 0px 20px 0px 40px;">Top Directors</a>
				</div>
			</div>
		</div>
		
			<div class="row">
				<div class="col-xs-3 ">
					<div class="well">
						This is Where Recommended Will Go
					</div>
				</div>
				
				
				<div class="col-xs-9 ">
					<div class="well">
						This is Where Queries/Top Results Will Go
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12 ">
					<div class="well">
						This is Where footer Will Go
					</div>
				</div>
				
			</div>
		
					<div class="row">
				<div class="col-xs-6 ">
				
				
				<div class="panel panel-default panel-danger">
				<div class="panel-heading"><h3 class="panel-title">This is the heading of the panel</h3></div>
				<div class="panel-body">
					This goes right in the stomach of panel
				</div>

				<table class="table">
					<tr>
						<th>Heading 1</th>
						<th>Heading 2</th>
						<th>Heading 3</th>
					</tr>
					<tr>
						<td>Content</td>
						<td>Content</td>
						<td>Content</td>
					</tr>
					<tr>
						<td>Content</td>
						<td>Content</td>
						<td>Content</td>
					</tr>
				</table>

				<div class="panel-footer">This is the footer</div>
			</div>
							</div>
				
			</div>
</head>
<body>



<!-- -<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>"> -->




</body>	
	
</div>
</div>
</html>

<!--
		<div class="navbar navbar-default navbar-inverse" align = "center" >
			<div class="container" align = "center" style="display:inline">
				<ul class="navbar-header" align = "center" style = "display:inline">
					<li><a href="index.php" class="navbar-brand" style="display:inline" >Search</a></li>
					<li><a href="index.php" class="navbar-brand" style="display:inline">Top Movies</a></li>
					<li><a href="index.php" class="navbar-brand" style="display:inline">Top Actors</a></li>
					<li><a href="index.php" class="navbar-brand" style="display:inline">Top Directors</a></li>
					<li><a href="index.php" class="navbar-brand" style="display:inline">Top Directors</a></li>
				</ul>
			</div>
		</div>
		
		-->



