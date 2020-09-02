<?php
$host = "localhost";
$username = "nabilf79_waseem";
$password = "123456789";
$db_name = "nabilf79_attendance_admin";
// Create connection
$conn = mysqli_connect($host, $username, $password,$db_name)or die("cannot connect");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>