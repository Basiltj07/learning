<?php
session_start();
if(!isset($_SESSION['login'])){
 header("Location:../admin/index.php");
}
ini_set('date.timezone', date_default_timezone_get());
include('database.php');

$sql = "SELECT * FROM tbl_batch where status = 1 order by id desc";
$result = mysqli_query($conn, $sql);

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
                    <li  class="current"><a href="index.php"><i class="glyphicon glyphicon-tasks"></i> Batch</a></li>
					<li><a href="student_registration.php"><i class="glyphicon glyphicon-tasks"></i> Registration</a></li>
					<li><a href="attendance.php"><i class="glyphicon glyphicon-tasks"></i> Attendance</a></li>
					<li><a href="attendance_report.php"><i class="glyphicon glyphicon-tasks"></i> Attendance Report</a></li>
                </ul>
             </div>
             <?php } ?>
		  </div>
		  <div class="col-md-10">

  			<div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title" style="width:100%;">List Batch
					<a href="add_batch.php"><button class="btn btn-primary" style="float:right;" >+ Add Batch</button></a>
					</div>
				</div>
  				<div class="panel-body">
  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
						<thead>
							<tr>
								<th>Batch Number</th>
								<th>Trainer</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Days</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php while($row=mysqli_fetch_assoc($result)) { ?>
							<tr class="even gradeX">
								<td><?php echo $row['batch_number']; ?></td>
								<td><?php echo $row['trainer']; ?></td>
								<td><?php echo date_format(date_create($row['start_date']),"d/m/Y"); ?></td>
								<td><?php echo date_format(date_create($row['end_date']),"d/m/Y"); ?></td>
								<td class="center"><?php echo $row['number_of_days']; ?></td>
								<td class="center"><a href="delete_batch.php?id=<?php echo $row['id']; ?>" >Delete</a></td>
							</tr>
						<?php } ?>
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
  </body>
</html>