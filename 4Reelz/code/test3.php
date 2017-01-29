
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
	<link href="style.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	
	
<title>CS 3380 Lab 8</title>
</head>
<body>
 

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

$json = get_url_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=batman');

$data = json_decode($json);

foreach ($data->responseData->results as $result) {
    $results[] = array('url' => $result->url, 'alt' => $result->title);
}

print_r($results);
?>
<?php foreach($results as $image): ?>
    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/><br/>
<?php endforeach; ?>


</body>
</html>

