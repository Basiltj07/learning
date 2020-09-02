<?php
include('common/header.php');
include('common/navbar.php');
include('common/sidenav.php');
include('config/database.php');
date_default_timezone_set('Asia/Dubai');
  $sqlQuery = "SELECT appointment.* ,GROUP_CONCAT(slot SEPARATOR ', ') as break_time FROM `appointment` inner join time_break on appointment.id = time_break.appointment_id where time_break.status =0 group by time_break.appointment_id";
  $result = mysqli_query($con, $sqlQuery);   
?>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid">
      <h1 class="mt-4">List Schedule</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">List Schedule</li>
      </ol>
      <div class="row">
        <div class="container">
          <table id="dataTableList" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Time Gap</th>
                <th>Break Time</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
          <?php while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {

            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['start_date']; ?></td>
                <td><?php echo date('d-m-Y',strtotime($row['end_date'])); ?></td>
                <td><?php echo $row['start_time']; ?></td>
                <td><?php echo $row['end_time']; ?></td>
                <td><?php echo $row['timegap']; ?></td>
                <td><?php echo $row['break_time']; ?></td>
                <td><a href="scheduleEdit.php?id=<?php echo $row['id'] ?> "><i class="fas fa-edit"></i></a></td>
            </tr>
            <?php }?>
            
        </tbody>
       
    </table>    
        </div>          
      </div>    
    </div>
  </main>
  <?php
  include('common/footercontent.php');
  include('common/footer.php');
  ?>