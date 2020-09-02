<?php
include('../config/database.php');
$date = date('Y-m-d',strtotime('+1 day'));
$autoBreakTimeupdate = "update time_break set status=0  where schedule_date = '$date' and block_status = 0  and status = 1 ";
$result = mysqli_query($con,$autoBreakTimeupdate);
$autoBreakBetweenUpdate = "update time_break set status=0  where schedule_date = '$date' AND STATUS =1 AND slot LIKE '11%am%' AND block_status =1";
$result = mysqli_query($con,$autoBreakBetweenUpdate);
?>