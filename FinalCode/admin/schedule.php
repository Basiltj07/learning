<?php
include('common/header.php');
include('common/navbar.php');
include('common/sidenav.php');
?>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid">
      <h1 class="mt-4">Schedule Appointment</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Schedule Appointment</li>
      </ol>
      <div class="row">
         <div class="container">
  
<form method="post" id="admin-save" action="save.php">
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="start-date">Start Date</label>
    
      <input type="text" class="form-control datepicker" name="start_date" id="start-date" placeholder="Start Date">
      <span id="startdate-error" class="error"></span>
    </div>
    <div class="form-group col-md-3">
      <label for="end-date">End Date</label>
      <input type="text" class="form-control datepicker" name="end_date" id="end-date" placeholder="End date">
      <span id="enddate-error" class="error"></span>
    </div>   
  </div>
  <div class="form-row">    
    <div class="form-group col-md-3">
      <label for="start-time">Start Time</label>
      <input type="text" class="form-control" name="startTime" id="start-time" value="" placeholder="Start Time">
      <span id="starttime-error" class="error"></span>
    </div>
    <div class="form-group col-md-3">
      <label for="end-time">End Time</label>
      <input type="text" class="form-control" name="endTime" id="end-time" placeholder="End Time ">
      <span id="endtime-error" class="error"></span>
    </div>
  </div>
  <div class="form-row">    
    <div class="form-group col-md-3">
      <label for="time-gap">Time gap</label>
      <input type="text" class="form-control" name="timeGap"  id="time-gap" placeholder="Time gap">
      <span id="timegap-error" class="error"></span>
    </div>
    <div class="form-group col-md-5">
      <label for="break-time">Break Time </label>
      <div id= "time-slot"></div>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="location">Location </label>
      <select class="custom-select" name="location[]" id="location" multiple>
      </select>
      <span id="location-error" class="error"></span>
    </div>
    <div class="form-group col-md-2">
         <span  class="btn btn-primary" id='loc_modal' data-toggle="modal" data-target="#commonModal">+</span>
    </div>   
  </div>
   <div class="form-row">
    
    <div class="form-group col-md-3">
      <label for="reason">Reason</label>
      <select class="custom-select" name="reason[]" id="reason" multiple>
      </select>
      <span id="reason-error" class="error"></span>
    </div>   
    <div class="form-group col-md-2">
         <span  class="btn btn-primary" id='reason_modal' data-toggle="modal" data-target="#commonModal">+</span>
    </div> 
  </div>
  <button type="button" name="save" id="save-schedule" class="btn btn-primary">Save</button>
</form>
</div>

    </div>
  </main>
  <?php
  include('common/footercontent.php');
  include('common/footer.php');
  ?>