<?php
session_start();
include('../admin/config/database.php');
include('../admin/common/emailTemplate.php');
require_once('mailerFunction.php');
date_default_timezone_set('Asia/Dubai');
if(isset($_POST['student_number']) && !empty($_SESSION['schid'])){
   $appointmentId = $_SESSION['schid'];
   $appointmentDate = date("Y-m-d",strtotime($_POST['appointment_date']));;
   $locationId = $_POST['location'];
   $timeSlotId = $_POST['time_slot'];
   $reasonId = $_POST['reason'];
   $name = $_POST['student_name'];
   $mobile = $_POST['student_mobile'];
   $email = $_POST['student_email'];
   $studentId = $_POST['student_number'];
   $isZoom = $_POST['location_type'];
   $status = 0;
   
   $insertQuery = "INSERT INTO book_appointment (`appointment_id`, `appointment_date`, `loc_id`, `reason_id`, `timeslot_id`, `name`, `email`, `mobile_number`, `student_number`, `status`,`location_type`) VALUES ($appointmentId,'$appointmentDate',$locationId,$reasonId,$timeSlotId,'$name','$email','$mobile','$studentId',$status,$isZoom)";
   mysqli_query($con, $insertQuery);
   $bookingId =  mysqli_insert_id($con);
   $startContent = "Dear ".$name;
   $emailContent = getEmailContentStudent();
   $title = 'Appointment booked';
   $template = getTemplate($emailContent,$startContent,$title);
   $isSend = sendEmail($title,$template,$email,$name);
   
   $adminData = "SELECT appointment_date,name,email,student_number,mobile_number,slot,locationname,schedule_reason.reason,book_appointment.location_type FROM book_appointment inner join schedule_location on book_appointment.loc_id= schedule_location.id inner join schedule_reason on schedule_reason.id = book_appointment.reason_id inner join time_break on time_break.id = book_appointment.timeslot_id where book_appointment.id = $bookingId";
   $result = mysqli_query($con,$adminData);
   $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
   $emailContentAdmin = getAdminTemplate($row);
   $startContentAdmin = 'Dear Admin,<br/>';
   $templateAdmin = getTemplate($emailContentAdmin,$startContentAdmin,$title);
   $isSendAdmin = sendEmail('New student Registered',$templateAdmin,'bzl00733@gmail.com','QHSE');
   header('Location:success.php');

} else {
	header('Location:error.php');
}

function getAdminTemplate($row){
   date_default_timezone_set('Asia/Dubai');
   $appointmentDate = date('d-m-Y',strtotime($row['appointment_date']));
   $name = $row['name'];
   $email = $row['email'];
   $studentNumber = $row['student_number'];
   $mobileNumber = $row['mobile_number'];
   $slot = $row['slot'];
   $locationName = $row['locationname'];
   $reason = $row['reason'];
   $type = ($row['location_type'] == 0) ? 'QHSE OFFICE' : 'ZOOM CALL';
   $table = "<table style='width: 80%;'>
               <tbody>               
               <tr>
                  <td  colspan='4'>There is new appointment booking from $name</td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
               <td colspan='2'>Name :</td>
               <td colspan='2'>$name</td>
               </tr>
               <tr>
               <td colspan='2'>Mobile Number :</td>
               <td colspan='2'>$mobileNumber</td>
               </tr>               
               <tr>
               <td colspan='2'>Email ID :</td>
               <td colspan='2'>$email</td>
               </tr>
                 <tr>
               <td colspan='2'>Student Number :</td>
               <td colspan='2'>$studentNumber</td>
               </tr>
                 <tr>
               <td colspan='2'>Date :</td>
               <td colspan='2'>$appointmentDate</td>
               </tr>
                 <tr>
               <td colspan='2'>Location :</td>
               <td colspan='2'>$locationName</td>
               </tr>
                   <tr>
               <td colspan='2'>Mode of Appointment :</td>
               <td colspan='2'>$type</td>
               </tr>
                   <tr>
               <td colspan='2'>Reason :</td>
               <td colspan='2'>$reason</td>
               </tr>
                   <tr>
               <td colspan='2'>Time :</td>
               <td colspan='2'>$slot</td>
               </tr>
                   <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
               <tr>
               <td colspan='4'>Kindly take necessary action for the appointment</td>
               </tr>
                 <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                 <tr>
               <td colspan='4'>Thank you!</td>
               </tr>
               </tbody>
               </table>";
               return $table;
}
function getEmailContentStudent(){
   $table = "<table style='width: 80%;'>
               <tbody>               
               <tr>
                  <td  colspan='4'>Good Day!</td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
                <tr>
                  <td  colspan='4'>Greetings from QHSE International!</td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
                <tr>
                  <td  colspan='4'>Thank you for showing your interest.</td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
                <tr>
                  <td  colspan='4'>This is an automatic reply confirming we have received your email for booking the appointment.</td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
                <tr>
                  <td  colspan='4'>However, if your inquiry needs urgent attention, you can contact us through +971 443 1124, from 9AM-6PM.</td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
                <tr>
                  <td  colspan='4'>Thank you so much!</td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>
               <tr>
                  <td  colspan='4'></td>
               </tr>


               </tbody>
               </table>";
               return $table;
}
?>



