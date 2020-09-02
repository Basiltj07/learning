<?php
session_start();
if(!isset($_SESSION['login'])){
 header("Location:../admin/index.php");
}
ini_set('date.timezone', date_default_timezone_get());
include('database.php');

$message = '';
if(isset($_POST['submit'])) {
if(empty($_POST['day'])) {
	 $message = "Please select atleast one day !!";
} else{
	$batch_number = $_POST['batch_number'];
	$tariner = $_POST['trainer'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$number_of_days = $_POST['number_of_days'];
	$weekdays = json_encode($_POST['day']);
	$startDate = strtotime('2020-08-02');
	$endDate = strtotime('2020-08-27');

	$diff = ($endDate - $startDate)/60/60/24; 

	if($diff < $number_of_days) {
		$message = "Number of days is greater compared to the start and end date !!";
	} else {
		$days = get_class_dates($start_date,$end_date, $weekdays);
		if(count($days) < $number_of_days) {
			$message = "Number of days doesnot match the selected weekdays !!";
		} else {
			$days = json_encode($days);
			$sql = "insert into tbl_batch(batch_number,trainer,start_date,end_date,start_time,end_time,number_of_days,week_days,class_dates,status) values('$batch_number','$tariner','$start_date','$end_date','$start_time','$end_time',$number_of_days,'$weekdays','$days',1)";
			mysqli_query($conn, $sql);
			$error = mysqli_errno($conn);
			if($error == 1062) {
				$message = "Batch Number Already Exists !!";
			} else {
				echo "<script>alert('Saved Successfully !!');</script>";
				header("Location: index.php");
			}
		}
	}
}
}

function get_class_dates($startDate,$endDate, $weekdays) {
	$startDate = new DateTime($startDate);
$endDate = new DateTime($endDate);
$week = json_decode($weekdays);
$sundays = array();

while ($startDate <= $endDate) {
    if (in_array($startDate->format('w') , $week)) {
		 $sundays[] = $startDate->format('Y-m-d');
    }

    $startDate->modify('+1 day');
}

return $sundays;
}

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

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="vendors/form-helpers/css/bootstrap-formhelpers.min.css" rel="stylesheet">
    <link href="vendors/select/bootstrap-select.min.css" rel="stylesheet">
    <link href="vendors/tags/css/bootstrap-tags.css" rel="stylesheet">

    <link href="css/forms.css" rel="stylesheet">

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

				<div class="row">
					<div class="col-md-12">
						<div class="content-box-large">
						<div class="panel-heading">
							<div class="panel-title">Add Batch</div><br />
							<?php if($message != '') { ?><button style="width:100%;" class="btn btn-danger btn-sm"><?php echo $message; ?></button><?php } ?>
						</div>
		  				<div class="panel-body">
						
						<form action="" method=post>
								<div class="row">
									<div class="col-sm-6">
										<label>Batch Number</label>
										<input type="text" class="form-control" value="<?php if(isset($_POST['batch_number'])){ echo $_POST['batch_number']; } ?>" required name="batch_number" placeholder="Batch Number">
									</div>
									<div class="col-sm-6">
										<label>Trainer</label>
										<input type="text" class="form-control" value="<?php if(isset($_POST['trainer'])){ echo $_POST['trainer']; } ?>" required name="trainer" placeholder="Trainer">
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<label>Date From</label>
										<p>
			  							<div class="bfh-datepicker" data-name="start_date" data-format="y-m-d" data-date="today"></div>
										</p>
									</div>
									<div class="col-sm-3">
										<label>Date To</label>
										<p>
			  							<div class="bfh-datepicker" data-name="end_date" data-format="y-m-d" data-date="today"></div>
										</p>
									</div>
									<div class="col-sm-3">
										<label>Start Time</label>
										<p>
			  							<div class="bfh-timepicker" data-name="start_time"></div>
										</p>
									</div>
									<div class="col-sm-3">
										<label>End Time</label>
										<p>
			  							<div class="bfh-timepicker" data-name="end_time"></div>
										</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-2">
										<label>Number Of Days</label>
										<input type="text" value="<?php if(isset($_POST['number_of_days'])){ echo $_POST['number_of_days']; } ?>" class="form-control" required name="number_of_days" placeholder="Number Of Days">
									</div>
									<div class="col-sm-10">
									<label>Select The Day</label><br />
												<label class="checkbox-inline">
													<input type="checkbox" name="day[]" value="0">
													Sunday </label>
												<label class="checkbox-inline">
													<input type="checkbox" name="day[]" value="1">
													Monday </label>
												<label class="checkbox-inline">
													<input type="checkbox" name="day[]" value="2">
													Tuesday </label>
												<label class="checkbox-inline">
													<input type="checkbox" name="day[]" value="3">
													Wednesday </label>
												<label class="checkbox-inline">
													<input type="checkbox" name="day[]" value="4">
													Thursday </label>
												<label class="checkbox-inline">
													<input type="checkbox" name="day[]" value="5">
													Friday </label>
												<label class="checkbox-inline">
													<input type="checkbox" name="day[]" value="6">
													Saturday </label>
											</div>
								</div>
								
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<input type="submit" class="form-control btn btn-primary" name="submit" >
									</div>
								</div>
						</form>
						</div>
		  			</div>
					</div>
				</div>


	  		<!--  Page content -->
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

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="vendors/form-helpers/js/bootstrap-formhelpers.min.js"></script>

    <script src="vendors/select/bootstrap-select.min.js"></script>

    <script src="vendors/tags/js/bootstrap-tags.min.js"></script>

    <script src="vendors/mask/jquery.maskedinput.min.js"></script>

    <script src="vendors/moment/moment.min.js"></script>

    <script src="vendors/wizard/jquery.bootstrap.wizard.min.js"></script>

     <!-- bootstrap-datetimepicker -->
     <link href="vendors/bootstrap-datetimepicker/datetimepicker.css" rel="stylesheet">
     <script src="vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script> 


    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    <script src="js/custom.js"></script>
    <script src="js/forms.js"></script>
  </body>
</html>