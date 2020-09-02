<?php 
	include('config/database.php');
	$locArray = $_POST['location'];
	$resArray = $_POST['reason'];
	$appointmentId = $_POST['hiddenId'];
	$deleteLoc = "delete from appointment_location where appointment_id = $appointmentId";
	mysqli_query($con, $deleteLoc);
	$deleteRes = "delete from appointment_reason where appointment_id = $appointmentId";
	mysqli_query($con, $deleteRes);
	foreach($locArray as $key=>$value){
		$locValue .= "($appointmentId, $value),";
	}
	$locValue = rtrim($locValue,',');
	$insertLocationInfo = "insert into appointment_location (`appointment_id`, `location_id`) values $locValue";

	 mysqli_query($con, $insertLocationInfo);
	 foreach($resArray as $key1=>$value1){
		$reasonValue .= "($appointmentId, $value1),";
	}
	$reasonValue = rtrim($reasonValue,',');
	$insertReasonInfo = "insert into appointment_reason (`appointment_id`, `reason_id`) values $reasonValue";
	mysqli_query($con, $insertReasonInfo);
	header('Location:schedulelist.php');
?>