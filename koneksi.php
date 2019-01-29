<?php 
$host = "localhost";
$user ="root";
$pass = "";
$db = "nbc";

$conn = mysqli_connect($host, $user, $pass, $db);
if($conn){
	echo "";
}else{
	echo "Koneksi gagal";
}
?>