<?php 
ob_start();
$conn= new mysqli('localhost','root','','beatus_db')or die("Could not connect to mysql".mysqli_error($conn));
?>