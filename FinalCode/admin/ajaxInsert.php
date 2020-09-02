<?php 
include('config/database.php');
if($_POST['type'] ==1){
	$location = $_POST['location'];
	$insertQuery = "INSERT INTO schedule_location (locationname) VALUES ('$location')";
} else {
	$reason = $_POST['reason'];
	$insertQuery = "INSERT INTO schedule_reason (reason) VALUES ('$reason')";
}
if(mysqli_query($con, $insertQuery)){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
}
?>