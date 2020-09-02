<?php
include('common/header.php');
include('common/navbar.php');
include('common/sidenav.php');
include('config/database.php');
$schId = $_GET['id'];
  $sql= "select appointment.* ,GROUP_CONCAT(DISTINCT(slot) SEPARATOR ', ') as time_break, GROUP_CONCAT(DISTINCT(location_id) SEPARATOR ', ') as location_id,GROUP_CONCAT(DISTINCT(reason_id) SEPARATOR ', ') as reason_id from appointment left join appointment_location on appointment.id = appointment_location.appointment_id left join appointment_reason on appointment_reason.appointment_id = appointment.id left join time_break on  time_break.appointment_id = appointment.id and time_break.status = 0 where appointment.id = $schId group by appointment.id";

$result =  mysqli_query($con, $sql);   
$rowData = mysqli_fetch_array($result,MYSQLI_ASSOC);
$breakArray = explode(',', $rowData['time_break']);
$locArray = explode(',', $rowData['location_id']);
$resArray = explode(',', $rowData['reason_id']);
$sqlQuery = "select * from schedule_location where status =1";
$resultLoc = mysqli_query($con, $sqlQuery);  
$sqlReason = "select * from schedule_reason where status =1";
$resultReason = mysqli_query($con, $sqlReason);   

?>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid">
      <h1 class="mt-4">Schedule Edit</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Schedule Edit</li>
      </ol>
      <div class="row">
         <div class="container">
  
<form method="post" action="update.php">
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="start-date">Start Date</label>
    
      <input type="text" class="form-control datepicker" name="start_date"  id="start-date" placeholder="Start Date" disabled="disabled" value=<?php echo $rowData['start_date'];?>>
    </div>
    <div class="form-group col-md-3">
      <label for="inputPassword4">End Date</label>
      <input type="text" class="form-control datepicker" name="end_date" id="end-date" placeholder="End date" disabled="disabled" value=<?php echo $rowData['end_date'];?>>
    </div>   
  </div>
  <div class="form-row">    
    <div class="form-group col-md-3">
      <label for="start-time">Start Time</label>
      <input type="text" class="form-control" name="startTime" id="start-time" value="10.43" placeholder="Start Time" disabled="disabled" value=<?php echo $rowData['start_time'];?>>

    </div>
    <div class="form-group col-md-3">
      <label for="end-time">End Time</label>
      <input type="text" class="form-control" name="endTime" id="end-time" placeholder="End Time " disabled="disabled" value=<?php echo $rowData['end_time'];?>>
    </div>
  </div>
  <div class="form-row">    
    <div class="form-group col-md-3">
      <label for="time-gap">Time gap</label>
      <input type="text" class="form-control" name="timeGap"  id="time-gap" placeholder="Time gap" disabled="disabled" value=<?php echo $rowData['timegap'];?>>
    </div>
    <div class="form-group col-md-5">
      <label for="break-time">Break Time </label>
      <div id= "time-slot">
        <?php foreach($breakArray as $key=>$value){
          echo "<input type='checkbox' checked='checked' disabled/> <label>$value</label>";
         } ?>
        </div>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="location">Location </label>
      <select class="custom-select" name="location[]" id="location_edit" multiple>
        <?php 
        while($rowLoc = mysqli_fetch_array($resultLoc,MYSQLI_ASSOC)) {
          $locId = $rowLoc['id'];
          $locName = $rowLoc['locationname'];
          if(in_array($locId, $locArray)){
            $str= "selected";
          } else {
            $str ='';
          }
          echo "<option value='$locId' $str>$locName</option>";
        }
        ?>
      </select>
    </div>
    <div class="form-group col-md-2">
         <span  class="btn btn-primary" id='loc_modal' data-toggle="modal" data-target="#commonModal">+</span>
    </div>   
  </div>
   <div class="form-row">
    
    <div class="form-group col-md-3">
      <label for="reason">Reason</label>
      <select class="custom-select" name="reason[]" id="reason_update" multiple>
        <?php 
        while($row = mysqli_fetch_array($resultReason,MYSQLI_ASSOC)) {
           $resId = $row['id'];
          $resName = $row['reason'];
          if(in_array($resId, $resArray)){
            $str= "selected";
          } else {
            $str ='';
          }
          echo "<option value='$resId' $str>$resName</option>";
        }
        ?>
      </select>
    </div>   
    <div class="form-group col-md-2">
         <span  class="btn btn-primary" id='reason_modal' data-toggle="modal" data-target="#commonModal">+</span>
    </div> 
    <input type="hidden" id="isEdit" value="<?php echo $schId?>" name="hiddenId">
  </div>
  <button type="submit" name="save" class="btn btn-primary">Save</button>
</form>
</div>
<!-- Modal try to use in separtea file-->
           
      </div>    
    </div>
  </main>
  <?php
  include('common/footercontent.php');
  include('common/footer.php');
  ?>