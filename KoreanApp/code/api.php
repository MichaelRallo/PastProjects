<?php
 
//Get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

//Connect to DB
include("secure/database.php");
$dbconn = connectDB();            
mysql_select_db('wordTables');

//Sample Path would be: http://localhost/api.php/{$user}
//Sample Path would be: http://localhost/api.php/{$user}/${wordID}
//Retrieve the user from the path
$user= $request[0];

if(sizeof($request) >= 2){
    $wordID = $request[1];
}
 
//Create SQL based on HTTP method
switch ($method) {
  case 'GET':
    $sql = "SELECT * FROM words WHERE (username='defaultUser' OR userName='$user')"; break;

  case 'POST':
    if($input !=null){
        $username = $input['username'];
        $wordType = $input['wordType'];
        $category = $input['category'];
        $koreanWord = $input['koreanWord'];
        $englishTranslation = $input['englishTranslation'];
        $romanization = $input['romanization'];
    }
    $sql = "INSERT INTO words(username, wordType, category, koreanWord, englishTranslation, romanization) VALUES('$username', '$wordType',  '$category', '$koreanWord', '$englishTranslation', '$romanization');"; break;
        
  case 'DELETE':
    $sql = "DELETE FROM words WHERE (id='$wordID' AND username='$user')"; break;
}
 
// excecute SQL statement
$result = mysql_query($sql, $dbconn);
 
// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysql_error());
}
if ($method == 'POST') {
    echo json_encode($input);
}  
if ($method == 'DELETE') {
    echo json_encode($input);
}  
// print results, insert id or affected row count
if ($method == 'GET') {
echo '[';
for ($i=0;$i<mysql_num_rows($result);$i++) {
echo ($i>0?',':'').json_encode(mysql_fetch_object($result));
}
echo ']';
} 
 
// close mysql connection
mysql_close($dbconn);
?>