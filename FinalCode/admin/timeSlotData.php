<?php
date_default_timezone_set('Asia/Dubai');
 $startTime = str_replace(' ', '', $_POST['startTime']);
 $endTime = str_replace(' ', '', $_POST['endTime']);
 $timeDuration = $_POST['timeGap'];

 $startTimeIn24Format  = date("H:i", strtotime($startTime));
 $endTimeIn24Format  = date("H:i", strtotime($endTime));
 SplitTime($startTimeIn24Format,$endTimeIn24Format,$timeDuration);
 function SplitTime($startTime, $endTime,$timeDuration, $duration="60"){
  date_default_timezone_set('Asia/Dubai');
    $timeArray = array ();
    $startTime    = strtotime ($startTime);
    $endTime      = strtotime ($endTime);

    $addMins  = $duration * $timeDuration;

    while ($startTime <= $endTime)
    {
        $timeArray[] = date ("G:i", $startTime);
        $startTime += $addMins; 
    }
    slotGeneration($timeArray);
}
function slotGeneration($timeArray){
  date_default_timezone_set('Asia/Dubai');
	$slotArray = array();
   for ($i = 0 ; $i < count($timeArray) -1 ; $i++){   	   
   	   $slotArray[$i] = date("g:i a", strtotime($timeArray[$i])).'-'.date("g:i a", strtotime($timeArray[$i+1]));
   }
   echo json_encode($slotArray);exit;
}
?>