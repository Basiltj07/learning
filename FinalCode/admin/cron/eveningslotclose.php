<?php
include('../config/database.php');
$date = date('Y-m-d');
$autoBreakTimeupdate = "update time_break set status=0  where schedule_date = '$date' and block_status = 1";
$result = mysqli_query($con,$autoBreakTimeupdate);

?>