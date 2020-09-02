<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$message = '';
if(isset($_POST['submit'])) {
if(empty($_POST['day'])) {
	 $message = "Please select atleast one day !!";
} else{
	$batch_number = $_POST['batch_number'];
	$tariner = $_POST['trainer'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$number_of_days = $_POST['number_of_days'];
	$weekdays = json_encode($_POST['day']);
	$startDate = strtotime('2020-08-02');
	$endDate = strtotime('2020-08-27');

	$diff = ($endDate - $startDate)/60/60/24; 

	if($diff < $number_of_days) {
		$message = "Number of days is greater compared to the start and end date !!";
	} else {
		$days = get_class_dates($start_date,$end_date, $weekdays);
		if(count($days) < $number_of_days) {
			$message = "Number of days doesnot match the selected weekdays !!";
		} else {
			$days = json_encode($days);
			$sql = "insert into tbl_batch(batch_number,trainer,start_date,end_date,start_time,end_time,number_of_days,week_days,class_dates,status) values('$batch_number','$tariner','$start_date','$end_date','$start_time','$end_time',$number_of_days,'$weekdays','$days',1)";
			mysqli_query($conn, $sql);
			$error = mysqli_errno($conn);
			if($error == 1062) {
				$message = "Batch Number Already Exists !!";
			} else {
				echo "<script>alert('Saved Successfully !!');</script>";
				header("Refresh: 0");
			}
		}
	}
}
}

function get_class_dates($startDate,$endDate, $weekdays) {
	$startDate = new DateTime($startDate);
$endDate = new DateTime($endDate);
$week = json_decode($weekdays);
$sundays = array();

while ($startDate <= $endDate) {
    if (in_array($startDate->format('w') , $week)) {
		 $sundays[] = $startDate->format('Y-m-d');
    }

    $startDate->modify('+1 day');
}

return $sundays;
}

?>