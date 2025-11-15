<?php  
$server_name = "localhost";
$db_name = "easyship";
$db_username = "root";
$db_password = "";

$con = mysqli_connect($server_name, $db_username, $db_password, $db_name);
if ($con === false) {
	echo "Database connection error ". mysqli_connect_error();
}
?> 
