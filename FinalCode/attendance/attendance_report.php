<?php
session_start();
if(!isset($_SESSION['login'])){
 header("Location:index.php");
}
ini_set('date.timezone', date_default_timezone_get());
include('database.php');


$currentDate = date('Y-m-d');

$sql = "select tbl_batch.id, tbl_batch.batch_number from tbl_batch where status = 1";
$result = mysqli_query($conn, $sql);

$batchId = isset($_GET['batch_id'])?$_GET['batch_id']:0;

$sql = "select tbl_attendance.id as attendance_id, tbl_students.*,tbl_attendance.*,tbl_batch.batch_number,tbl_batch.end_time from tbl_attendance join tbl_students on tbl_students.id = tbl_attendance.student_id join tbl_batch on tbl_batch.id = tbl_attendance.batch_id where tbl_attendance.batch_id = $batchId and tbl_batch.status = 1 group by tbl_attendance.student_id";
$result1 = mysqli_query($conn, $sql);
$report = array();
while($row = mysqli_fetch_assoc($result1)) {
	$sql = "select * from tbl_attendance where student_id = ".$row['student_id']." and batch_id = ".$batchId;
	$result2 = mysqli_query($conn, $sql);
	$att = array();
	while($at = mysqli_fetch_assoc($result2)){
		$att[] = $at;
	}
	$row['attendance'] = $att;
	$report[] = $row;
}

$sql = "select tbl_batch.number_of_days from tbl_batch where id = ".$batchId;
$result3 = mysqli_query($conn, $sql);
$days = mysqli_fetch_assoc($result3);
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
					<li><a href="attendance.php"><i class="glyphicon glyphicon-tasks"></i> Attendance</a></li>
					<li class="current"><a href="attendance_report.php"><i class="glyphicon glyphicon-tasks"></i> Attendance Report</a></li>
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
										    <option value="attendance_report.php?batch_id=<?php echo $row['id']; ?>"><?php echo $row['batch_number']; ?></option>
										<?php } ?>
										  </select>
										</p>
									</div>
					</div>
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
								<?php for($i=1;$i<=$days['number_of_days']; $i++) { $j=$i-1; 
								$dat = empty($report)?'0000-00-00':$report[0]['attendance'][$j]['class_date'];
								?>
								<th>Day <?php echo $i." - ".date_format(date_create($dat),"d/m/Y"); ?></th>
								<th>Time In</th>
								<th>Time Out</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
						<?php foreach($report as $reports){  $i=1; ?>
							<tr class="even gradeX">
								<td><?php echo $i; ?></td>
								<td><?php echo $reports['full_name']; ?></td>
								<td><?php echo $reports['gender']; ?></td>
								<td><?php echo $reports['mobile_number']; ?></td>
								<td><?php echo $reports['language']; ?></td>
								<td><?php echo $reports['email_id']; ?></td>
								<td><?php echo $reports['country']; ?></td>
								<td><?php echo $reports['dob']; ?></td>
								<td><?php echo $reports['batch_number']; ?></td>
								<?php foreach($reports['attendance'] as $attendance_report) { ?>
								<td><?php if($attendance_report['attendance_status'] == 1) { echo ' Present ' ; } else { 'Absent'; } ?></td>
								<td><?php echo date_format(date_create($attendance_report['in_time']),"h:i:s"); ?></td>
								<td><?php echo date_format(date_create($attendance_report['out_time']),"h:i:s"); ?></td>
								<?php } ?>
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

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script src="vendors/datatables/dataTables.bootstrap.js"></script>

    <script src="js/custom.js"></script>
    <script src="js/tables.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
	
	
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