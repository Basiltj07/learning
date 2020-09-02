<?php
session_start();
include('../admin/config/database.php');
date_default_timezone_set('Asia/Dubai');
if($_POST['type'] == 1){
	$currentTime = date('H:i');
	$eveningSlotClose = date('10:55');
	$morningSlotClose = date('16:00');
	defaultTimeSlotUpdate($con);
	if($currentTime > $eveningSlotClose){
		timeSlotMorningUpdate($con);
	} 
	if($currentTime > $morningSlotClose){
		timeSlotEveningUpdate($con);
	}
	$startDate = date("Y-m-d", strtotime($_POST['apointmentDate']));
	$schduleId = getSchId($startDate,$con);
	$_SESSION['schid'] = $schduleId;
	$getLocation = "select locationname,schedule_location.id from appointment_location inner join schedule_location on appointment_location.location_id = schedule_location.id where appointment_id = $schduleId";
	$resultLoc = mysqli_query($con, $getLocation);   
	while($rowLoc = mysqli_fetch_array($resultLoc,MYSQLI_ASSOC)) {
		$response['location'][$rowLoc['id']] = $rowLoc['locationname'];
	}

	$getReason = "select reason,schedule_reason.id from appointment_reason inner join schedule_reason on appointment_reason.reason_id = schedule_reason.id where appointment_id = $schduleId";
	$resultReason = mysqli_query($con, $getReason);   
	while($rowRes = mysqli_fetch_array($resultReason,MYSQLI_ASSOC)) {
		$response['reason'][$rowRes['id']] = $rowRes['reason'];
	}
	echo json_encode($response);

} else if($_POST['type'] == 2){	
	$startDate = date("Y-m-d", strtotime($_POST['apointmentDate']));
	$locId = $_POST['locId'];
    $schduleId =  $_SESSION['schid'];   
	$loctype = $_POST['loc_type'];
	if($loctype == 0){
		$condition = " where appointment_id = $schduleId and type = $loctype and status != 0";
	} else {
		$condition = " where appointment_id = $schduleId and status != 0";
	}
	$getTimeData = "select slot,id from time_break $condition and id not in (select timeslot_id from book_appointment where appointment_id =  $schduleId and loc_id = $locId)";
	$resultTimeData = mysqli_query($con, $getTimeData);   
	while($rowTime = mysqli_fetch_array($resultTimeData,MYSQLI_ASSOC)) {
		$response['timeSlot'][$rowTime['id']] = $rowTime['slot'];
	}
	echo json_encode($response);

} else if($_POST['type'] == 3){
	$studentEmail = $_POST['studentEmail'];
	$apointmentDate = date("Y-m-d", strtotime($_POST['apointmentDate']));
	$reasonId = $_POST['reasonId'];
	$isExist = "select id from book_appointment where appointment_date ='$apointmentDate' and reason_id =$reasonId and email ='$studentEmail'";
	$result = mysqli_query($con,$isExist);
	$row = mysqli_num_rows($result);
	if($row > 0){
		$bookedDate = $_POST['apointmentDate'];
		$response = array('status'=>0,'msg'=>"Already you have an Appointment with $studentEmail on $bookedDate");
	} else {
		$response = array('status'=>1,'msg'=>'new appointment');
	}
	echo json_encode($response);
} else if($_POST['type'] == 4){	
	$locId = $_POST['locId'];
	$apointmentDate = date("Y-m-d", strtotime($_POST['apointmentDate']));
	$timeSlotId = $_POST['timeSlot'];
	$isExist = "select id from book_appointment where appointment_date ='$apointmentDate' and loc_id =$locId and timeslot_id =$timeSlotId";
	$result = mysqli_query($con,$isExist);
	$row = mysqli_num_rows($result);
	if($row > 0){;
		$response = array('status'=>0,'msg'=>"Slot is already booked");
	} else {
		$response = array('status'=>1,'msg'=>'new appointment');
	}
	echo json_encode($response);

}
function getSchId($dateParam,$con){
	$getScheduleId = "select id from appointment where start_date = '$dateParam'";
	$result = mysqli_query($con, $getScheduleId);   
	$row = mysqli_fetch_row($result);
	return $row[0];
}
function timeSlotMorningUpdate($con){
	date_default_timezone_set('Asia/Dubai');
	$date = date('Y-m-d');
	$autoBreakTimeupdate = "update time_break set status=0  where schedule_date = '$date' and status = 1";
	$result = mysqli_query($con,$autoBreakTimeupdate);
}
function timeSlotEveningUpdate($con){
	date_default_timezone_set('Asia/Dubai');
	$date = date('Y-m-d',strtotime('+1 day'));
	$autoBreakTimeupdate = "update time_break set status=0  where schedule_date = '$date' and block_status = 0  and status = 1";
	$result = mysqli_query($con,$autoBreakTimeupdate);
	$autoBreakBetweenUpdate = "update time_break set status=0  where schedule_date = '$date' AND STATUS =1 AND slot LIKE '11%am%' AND block_status =1";
	$result = mysqli_query($con,$autoBreakBetweenUpdate);
}
function defaultTimeSlotUpdate($con){
	date_default_timezone_set('Asia/Dubai');
	$date = date('Y-m-d');
	$autoBreakTimeupdate = "update time_break set status=0  where schedule_date = '$date' and slot like '%am%' ";
	$result = mysqli_query($con,$autoBreakTimeupdate);
}

?>