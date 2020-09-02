<?php
include('common/header.php');
include('common/navbar.php');
include('common/sidenav.php');
include('config/database.php');
date_default_timezone_set('Asia/Dubai');
$todaydate = date("Y-m-d");
$todayBooking = "SELECT count(*) as count from book_appointment where appointment_date ='$todaydate'";
$result = mysqli_query($con,$todayBooking);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$count = $row['count'];
?>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid">
      <h1 class="mt-4">Dashboard</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
      <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card bg-primary text-white mb-4">
             <div class="card-body">Todays appointment <?php echo $count;?></div>
          </div>
        </div>             
      </div>    
    </div>
  </main>
  <?php
  include('common/footercontent.php');
  include('common/footer.php');
  ?>