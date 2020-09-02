<?php 
include('config/database.php');
if($_POST['type'] == 1){
	$sqlQuery = "select * from schedule_location where status =1";
	$result = mysqli_query($con, $sqlQuery);   
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
	  $response[$row['id']] = $row['locationname'];
	}
	
} else {
	$sqlQuery = "select * from schedule_reason where status =1";
	$result = mysqli_query($con, $sqlQuery);   
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		$response[$row['id']] = $row['reason'];
	}
}
echo json_encode($response);

?>