<?php
include('common/header.php');
include('common/navbar.php');
include('common/sidenav.php');
include('config/database.php');
date_default_timezone_set('Asia/Dubai');
  $startDate = date("Y-m-d");
  $endDate = date("Y-m-d");
  if(isset($_POST['search'])){
    $startDate = date("Y-m-d", strtotime($_POST['start_date']));
    $endDate = date("Y-m-d", strtotime($_POST['end_date']));
  }
$sqlQuery = "SELECT book_appointment.id as bookingid , book_appointment.appointment_date,book_appointment.name,book_appointment.email,book_appointment.mobile_number,book_appointment.student_number,schedule_location.locationname,schedule_reason.reason, time_break.slot, book_appointment.reason as cancelled_reason,book_appointment.status, book_appointment.location_type FROM book_appointment
inner join schedule_reason on schedule_reason.id = book_appointment.reason_id inner join time_break on time_break.id = book_appointment.timeslot_id inner join schedule_location on schedule_location.id = book_appointment.loc_id where appointment_date between '$startDate' and '$endDate'";
$result = mysqli_query($con, $sqlQuery);
$statusArray= array(0=>'Pending',1=>'Cancelled',2=>'Closed');  
?>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid">
      <h1 class="mt-4">List Appointment</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">List Appointment</li>
      </ol>
      <div class="row">
        <div class="container">
                  <br/>
        <div>
            <form method='post' action ='appointmentList.php'>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="start-date1">Start Date</label>

                    <input type="text" class="form-control datepicker" name="start_date" id="start-date1"  placeholder="Start Date">
                </div>
                <div class="form-group col-md-3">
                    <label for="end-date1">End Date</label>
                    <input type="text" class="form-control datepicker" name="end_date" id="end-date1"  placeholder="End date" >
                </div>  
                <input type="hidden" value = "<?php echo $startDate;?>" id="startDatevalue"/>
              
            </div>

                    <button type="submit" name="search" class="btn btn-primary" >Search</button>
               
        </div>
        <br/> <br/>
        <div id="table-data">
 <table id="dataTableList" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Sl. No</th>
                <th>Name</th>
                <th>Mobile Number</th>
                <th>Email ID</th>
                <th>Student Number</th>
                <th>Appointment Date</th>
                <th>Location</th>
                <th>Reason</th>
                <th>Time Slot</th>
                <th>Location Type</th>
                <th>Cancelled Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0;while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                $i=$i+1;
                $locationType = ($row['location_type'] ==0) ? 'QHSE OFFICE' :'ZOOM CALL'
                ?>
            <tr>
                <td><?php echo $row['bookingid']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['mobile_number']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['student_number']; ?></td>
                <td><?php echo date("d-m-Y",strtotime($row['appointment_date'])); ?></td>
                <td><?php echo $row['locationname']; ?></td>
                <td><?php echo $row['reason']; ?></td>
                <td><?php echo $row['slot']; ?></td>
                <td><?php echo $locationType; ?></td>
                <td><?php echo $row['cancelled_reason']; ?></td>
                <td><?php echo $statusArray[$row['status']];?></td>
                <td><?php if($row['status'] == 0){?>
                    <select name='action' class='trainer-action' id='trainer-action'  data-id=<?php echo $row['bookingid'];?>>
                        <option value=''>-select-</option>
                        <option value='0'>Email</option>
                        <option value='1'>Cancel</option>
                        <option value='2'>Close</option>
                    </select>
                     <?php } else {echo $statusArray[$row['status']];}?>
                </td>
            </tr>
            <?php }?>
            
        </tbody>
       
    </table></div>
        </div>          
      </div>    
    </div>
  </main>
      <?php 
     include('common/footercontent.php');
     include('common/footer.php');
?>
