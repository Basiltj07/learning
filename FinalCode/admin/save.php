<?php 
include('config/database.php');
date_default_timezone_set('Asia/Dubai');
 $startDate = date("Y-m-d",strtotime($_POST['start_date']));
 $endDate = date("Y-m-d",strtotime($_POST['end_date']));
 $startTime = str_replace(' ', '', $_POST['startTime']);
 $endTime = str_replace(' ', '', $_POST['endTime']);
 $timeDuration = $_POST['timeGap'];
 $locArray = $_POST['location'];
 $reason = $_POST['reason'];
 $breakArray = $_POST['slot'];
 
 $startTimeIn24Format  = date("H:i", strtotime($startTime));
 $endTimeIn24Format  = date("H:i", strtotime($endTime));
 $timeSlotCon = array('startTime'=>$startTimeIn24Format,'endTime'=>$endTimeIn24Format,'timeDuration'=>$timeDuration,'breakTime'=>$breakArray);
 $getTimearray = SplitTime($timeSlotCon);
 $dateArray = getDatesFromRange($startDate, $endDate);
 if(isset($_POST['start_date'])){
    foreach($dateArray as $key=>$value){
	    $startDate1 =$endDate1 = $value;
	    
	 	$insertAppointMent = "insert into appointment (`start_date`, `end_date`, `start_time`, `end_time`, `timegap`) values('$startDate1','$endDate1','$startTime','$endTime','$timeDuration')";
	    mysqli_query($con, $insertAppointMent);
	 	$appointmentId = mysqli_insert_id($con);
	  slotInsertion($getTimearray,$appointmentId,$startDate1,$con);
	  insertLocation($locArray,$appointmentId,$con);
	 	insertReason($reason,$appointmentId,$con);
 	}
   redirect();
 }
 function insertLocation($location,$appointmentId,$con){
    foreach($location as $key=>$value){
    	$locValue .= "($appointmentId, $value),";
    }
    $locValue = rtrim($locValue,',');
    $insertLocationInfo = "insert into appointment_location (`appointment_id`, `location_id`) values $locValue";
    mysqli_query($con, $insertLocationInfo);
 }
 function insertReason($reason,$appointmentId,$con){
    foreach($reason as $key=>$value){
    	$reasonValue .= "($appointmentId, $value),";
    }
    $reasonValue = rtrim($reasonValue,',');
    $insertReasonInfo = "insert into appointment_reason (`appointment_id`, `reason_id`) values $reasonValue";
    mysqli_query($con, $insertReasonInfo);
 }

 function SplitTime($timeSlot,$duration="60"){
   date_default_timezone_set('Asia/Dubai');
    $timeArray = array ();
    $startTime    = strtotime ($timeSlot['startTime']);
    $endTime      = strtotime ($timeSlot['endTime']);

    $addMins  = $duration * $timeSlot['timeDuration'];
    while ($startTime <= $endTime)
    {
        $timeArray[] = date ("G:i", $startTime);
        $startTime += $addMins; 
    }
   return slotGeneration($timeArray,$timeSlot['breakTime']);
}
function slotGeneration($timeArray,$breakArray){
  date_default_timezone_set('Asia/Dubai');
	$j = 0;
	$slotArray = array();
   for ($i = 0 ; $i < count($timeArray) -1 ; $i++){  
       ; 
       $currentTime = new DateTime($timeArray[$i+1]);
       $officeTime  = new DateTime('17:30:00');	
       $blockTime = new DateTime('12:00:00');
   	   $slotArray[$i]['slot']= date("g:i a", strtotime($timeArray[$i])).'-'.date("g:i a", strtotime($timeArray[$i+1]));
   	   
   	   if($currentTime >= $officeTime){
   	   		$slotArray[$i]['type'] = 1;
   	   } else {   	   	
   	   		$slotArray[$i]['type'] = 0;
   	   }
   	   if (in_array($i, $breakArray)){
   	   		$slotArray[$i]['status'] = 0;
   	   } else {
   	   		$slotArray[$i]['status'] = 1;
   	   }
       if($currentTime >= $blockTime){
          $slotArray[$i]['block_status'] = 1;
       } else {
          $slotArray[$i]['block_status'] = 0;
       }
   	   $j++;
   	   $slotArray[$i]['slotname'] = 'slot'.$j;
   }
   return $slotArray;
}
function slotInsertion($timeArray,$appointmentId,$dateschedule,$con){
	foreach($timeArray as $key=>$value){
		$type = $value['type'];
		$slot = $value['slot'];
		$status = $value['status'];
		$slotName = $value['slotname'];
    $blockStatus = $value['block_status'];
		$breakTime .= "($appointmentId, '$slot','$slotName',$type,$status,$blockStatus,'$dateschedule'),";
	}
	$breakTime = rtrim($breakTime,',');
    $insertBreakTime = "insert into time_break (`appointment_id`,`slot`,`slot_name`,`type`,`status`,`block_status`,`schedule_date`) values $breakTime";
    mysqli_query($con, $insertBreakTime);
}
function getDatesFromRange($start, $end, $format = 'Y-m-d') { 
    date_default_timezone_set('Asia/Dubai');
    $dateArray = array(); 
    $interval = new DateInterval('P1D'); 
    $realEnd = new DateTime($end); 
    $realEnd->add($interval); 
  
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
    foreach($period as $date) { 
    	$dateArray[] = $date->format($format);
    } 
    return $dateArray; 
}
function redirect(){
  header('Location:schedulelist.php');
}
?>