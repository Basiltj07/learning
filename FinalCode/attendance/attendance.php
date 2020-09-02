<?php
session_start();
ini_set('date.timezone', date_default_timezone_get());
include('database.php');

$currentDate = date('Y-m-d');

$sql = "select tbl_batch.id, tbl_batch.batch_number from tbl_attendance join tbl_batch on tbl_batch.id = tbl_attendance.batch_id where class_date = '$currentDate' group by batch_id";
$result = mysqli_query($conn, $sql);

$batchId = isset($_GET['batch_id'])?$_GET['batch_id']:0;

$sql = "select tbl_attendance.id as attendance_id, tbl_students.*,tbl_attendance.*,tbl_batch.batch_number,tbl_batch.end_time from tbl_attendance join tbl_students on tbl_students.id = tbl_attendance.student_id join tbl_batch on tbl_batch.id = tbl_attendance.batch_id where tbl_attendance.batch_id = $batchId and tbl_attendance.class_date = '$currentDate' and tbl_batch.status = 1 ";
$result1 = mysqli_query($conn, $sql);

$sql = "select day_number from tbl_attendance where tbl_attendance.batch_id = $batchId and tbl_attendance.class_date = '$currentDate' limit 0,1 ";
$result2 = mysqli_query($conn, $sql);
$dayrow = mysqli_fetch_assoc($result2);
$day = $dayrow['day_number'];


?>
<!DOCTYPE html>
<html>
  <head>
    <title>Attendance Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery UI -->
    <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-5">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="../admin/dashboard.php">Attendance</a></h1>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

    <div class="page-content">
    	<div class="row">
		  <div class="col-md-2">
		  	<?php if(isset($_SESSION['login'])){ ?>
		  	<div class="sidebar content-box" style="display: block;">
                <ul class="nav">
                    <!-- Main menu -->
                    <li><a href="index.php"><i class="glyphicon glyphicon-tasks"></i> Batch</a></li>
					<li><a href="student_registration.php"><i class="glyphicon glyphicon-tasks"></i> Registration</a></li>
					<li  class="current"><a href="attendance.php"><i class="glyphicon glyphicon-tasks"></i> Attendance</a></li>
					<li><a href="attendance_report.php"><i class="glyphicon glyphicon-tasks"></i> Attendance Report</a></li>
                </ul>
             </div>
             <?php } ?>
		  </div>
		  <div class="col-md-10">

  			<div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title" style="width:100%;">Attendance
					<div style="float:right;">
										<p>
										<label>Select A Batch</label>
			  							<select class="selectpicker" name="batch_id" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
										<option value="">--Select--</option>
										<?php  while($row = mysqli_fetch_assoc($result)) { ?>
										    <option value="attendance.php?batch_id=<?php echo $row['id']; ?>"><?php echo $row['batch_number']; ?></option>
										<?php } ?>
										  </select>
										</p>
									</div>
					</div>
					<a href="student_registration.php"><button class="btn btn-primary" style="float:right;" >+ Student Registration</button></a>
					
				</div>
  				<div class="panel-body">
  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
						<thead>
							<tr>
								<th>SL NO</th>
								<th>Name</th>
								<th>Gender</th>
								<th>Mobile Number</th>
								<th>Email Id</th>
								<th>Language</th>
								<th>Country</th>
								<th>DOB</th>
								<th>Batch</th>
								<th>Proof</th>
								<th>Day <?php echo $day." - ".date_format(date_create($currentDate),"d/m/Y"); ?></th>
								<th>Time In</th>
								<th>Time Out</th>
							</tr>
						</thead>
						<tbody>
						<?php while($row=mysqli_fetch_assoc($result1)) { $i=1; ?>
							<tr class="even gradeX">
								<td><?php echo $i; ?></td>
								<td><?php echo $row['full_name']; ?></td>
								<td><?php echo $row['gender']; ?></td>
								<td><?php echo $row['mobile_number']; ?></td>
								<td><?php echo $row['language']; ?></td>
								<td><?php echo $row['email_id']; ?></td>
								<td><?php echo $row['country']; ?></td>
								<td><?php echo $row['dob']; ?></td>
								<td><?php echo $row['batch_number']; ?></td>
								<td><a href="<?php echo $row['identification_id']; ?>" target="_blank">View</a></td>
								<td><input type="checkbox" <?php if($row['attendance_status'] == 1) { echo ' checked disabled="disabled" '; } ?>  onClick="mark_attendance(<?php echo $row['attendance_id']; ?>,<?php echo $batchId ?>,'<?php echo $row['end_time']; ?>');" /> <?php if($row['attendance_status'] == 1) { ?> <a href="reset_attendance.php?id=<?php echo $row['attendance_id']; ?>&batch_id=<?php echo $batchId ?>">Reset</a> <?php } ?></td>
								<td><?php echo date_format(date_create($row['in_time']),"h:i:s"); ?></td>
								<td><?php echo date_format(date_create($row['out_time']),"h:i:s"); ?></td>
							</tr>
						<?php $i++; } ?>
						</tbody>
					</table>
  				</div>
  			</div>



		  </div>
		</div>
    </div>

    <footer>
         <div class="container">
         
            <div class="copy text-center">
               Copyright <?php echo date('Y'); ?> <a href='#'>Website</a>
            </div>
            
         </div>
      </footer>

      <link href="vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="vendors/datatables/js/jquery.dataTables.min.js"></script>

    <script src="vendors/datatables/dataTables.bootstrap.js"></script>

    <script src="js/custom.js"></script>
    <script src="js/tables.js"></script>
	
<script>
function mark_attendance(id,batch_id,out_time) {
	var obj = {
			 'id':id,
			 'time_out' : out_time
		}
	$.ajax({
          type: "POST",
          url: 'mark_attendance.php',
		  data: obj,
          success: function(response) { 
	          	window.location = 'attendance.php?batch_id='+batch_id;
			}
    	})
}
</script>
  </body>
</html>