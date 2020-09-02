<?php
ini_set('date.timezone', date_default_timezone_get());
include('database.php');

$out = $_POST['time_out'];
$in = date('H:i:00');

$sql = "update tbl_attendance set attendance_status = 1, in_time = '$in', out_time = '$out' where id = ".$_POST['id'];
mysqli_query($conn, $sql);
?>