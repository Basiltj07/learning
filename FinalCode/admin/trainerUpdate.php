<?php 
include('config/database.php');
include('common/emailTemplate.php');
include('mailerFunction.php');
if($_POST['type'] == 0){
	$bookingId = $_POST['bookId'];
	$content = $_POST['content'];
	$updateQuery = "UPDATE book_appointment set email_content = '$content' where id = $bookingId";
	$result = mysqli_query($con,$updateQuery);	
	$isUpdate = mysqli_affected_rows($con);
	if($isUpdate > 0){		
		studentSendEmail($con,$bookingId,0);
	}	
	
} else if($_POST['type'] == 1){
	$bookingId = $_POST['bookId'];
	$content = $_POST['content'];
	$updateQuery = "UPDATE book_appointment set reason = '$content', status = 1 where id = $bookingId";

	$result = mysqli_query($con,$updateQuery);
	$isUpdate = mysqli_affected_rows($con);

	if($isUpdate > 0){		
		studentSendEmail($con,$bookingId,1);	
	}
} else { 
	$bookingId = $_POST['bookId'];
	$updateQuery = "UPDATE book_appointment set  status=2 where id = $bookingId";
	$result = mysqli_query($con,$updateQuery);
}

function studentSendEmail($con,$bookingId,$type){
	$getInfo = "select name,email,student_number,email_content,reason from book_appointment where id= $bookingId";
	$result = mysqli_query($con,$getInfo);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$startContent = 'Dear '.$row['name'];
	$email = $row['email'];
	$emailContent = ($type == 0) ? $row['email_content']: $row['reason'];
	$studentId = $row['student_number'];
	$title = ($type == 0) ? 'Appointment': 'Appointment Cancelled';
	$template = getTemplate($emailContent,$startContent,$title);
	$isSend = sendEmail($title,$template,$email,$$row['name']);
	if($isSend){
		$response= array('status'=>1,'msg'=>'success');
	} else {
		$response= array('status'=>0,'msg'=>'failed');
	}
	echo json_encode($response);

}
