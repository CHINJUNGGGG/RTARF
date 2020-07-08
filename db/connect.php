  
<?php
$hostname = 'multiinnovation_db_1';
$username = 'root';
$password = 'root';
$database = 'rtarf';

// $hostname = 'localhost';
// $username = 'rtarf';
// $password = '';
// $database = 'rtarf';

$conn =  new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error){
	die("Connection Failed : ".$conn->connect_error);
}
$conn->set_charset("utf8");
?>