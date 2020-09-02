<?php
session_start();
if(!isset($_SESSION['login'])){
 header("Location:index.php");
}
ini_set('date.timezone', date_default_timezone_get());
include('database.php');

$sql = "update tbl_batch set status = 0 where id = ".$_GET['id'];
mysqli_query($conn, $sql);
header("Location: index.php");
?>