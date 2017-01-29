<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Search API Sample</title>


  </head>
  <body style="font-family: Arial;border: 0 none;">
    <div id="branding"  style="float: left;"></div><br />
    <div id="content">Loading...</div>
	
	<div style="width:300px;height:300px;background-color:green;">
	<?php
	
	
function get_url_contents($url) {
    $crl = curl_init();

    curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
    curl_setopt($crl, CURLOPT_URL, $url);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);

    $ret = curl_exec($crl);
    curl_close($crl);
    return $ret;
}

$movieName = "A CLockwork Orange";
$movieName = str_replace(' ', "", $movieName);
$year = 1971;
$json = get_url_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q='.$movieName.'+' . $year . '+filmposter');
$data = json_decode($json);

foreach ($data->responseData->results as $result) 
{
    $results[] = array('url' => $result->url, 'alt' => $result->title);
}
?>
	
	
<?php 
$counter = 0; 
foreach($results as $image):
	$counter++; 
	if($counter > 1) 
		break; 
		?>
			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/><br/>
		<?php
 endforeach; 
 ?>



	<p>END</p>
	</div>
	
	</div>
  </body>
</html>