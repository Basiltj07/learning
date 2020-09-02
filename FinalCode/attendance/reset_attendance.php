<?php
ini_set('date.timezone', date_default_timezone_get());
include('database.php');

$id = $_GET['id'];
$batch_id = $_GET['batch_id'];

$sql = "update tbl_attendance set attendance_status = 0, in_time = '00:00:00', out_time = '00:00:00' where id = ".$id;
mysqli_query($conn, $sql);
header("Location: attendance.php?batch_id=$batch_id");
?>