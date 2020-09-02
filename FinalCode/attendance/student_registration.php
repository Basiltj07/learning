<?php
session_start();
ini_set('date.timezone', date_default_timezone_get());
include('database.php');

$sql = "SELECT * FROM tbl_batch where class_dates like '%".date('Y-m-d')."%'";
$result = mysqli_query($conn, $sql);

$message = '';
if(isset($_POST['submit'])) {
	$full_name = $_POST['full_name'];
	$gender = $_POST['gender'];
	$mobile_number = $_POST['mobile_number'];
	$email_id = $_POST['email_id'];
	$language = $_POST['language'];
	$country = $_POST['country'];
	$dob = $_POST['dob'];
	//$identification_id = $_POST['identification_id'];
	$batch_id = $_POST['batch_id'];
	$sql = "SELECT * FROM tbl_students where batch_id = $batch_id and (mobile_number = '$mobile_number' or email_id = '$email_id')";
	$batch_exixsts = mysqli_query($conn, $sql);
	$batch_count = mysqli_num_rows($batch_exixsts);
	if($batch_count > 0) {
		$message = "Already registered in the batch !!";
	} else {
		if(!empty($_FILES)) {
			$uploaddir = 'uploads/';
			$uploadfile = $uploaddir . str_replace(" ","_",basename($_FILES['identification_id']['name']));
			if (move_uploaded_file($_FILES['identification_id']['tmp_name'], $uploadfile)) {
				$identification_id = 'uploads/'.str_replace(" ","_",basename($_FILES['identification_id']['name']));
			} else {
				$identification_id = '';
			}
		}
		
		$sql = "insert into tbl_students(full_name,gender,mobile_number,email_id,language,country,dob,identification_id,batch_id) values('$full_name','$gender','$mobile_number','$email_id','$language','$country','$dob','$identification_id',$batch_id)";
		mysqli_query($conn, $sql);
		$error = mysqli_errno($conn);
		if($error == 0) {
			$last_id = mysqli_insert_id($conn);
			$sql = "SELECT * FROM tbl_batch where id = $batch_id";
			$result1 = mysqli_query($conn, $sql);
			$row1 = mysqli_fetch_assoc($result1);
			for($i=0;$i<$row1['number_of_days'];$i++) {
				$attendance_stat = ($i==0)?1:0;
				$weekdays = json_decode($row1['class_dates']);
				$classDate = $weekdays[$i];
				$tim = date('H:i');
				if($i==0){
					$in_time = ($tim < $row1['start_time'])?$row1['start_time']:$tim;
					$out_time = $row1['end_time'];
				} else {
					$in_time = '00:00';
					$out_time = '00:00';
				}
				$day_number = $i+1;
				$sql1 = "insert into  tbl_attendance(batch_id,student_id,attendance_status,in_time,out_time,day_number,class_date) values('$batch_id','$last_id',$attendance_stat,'$in_time','$out_time',$day_number,'$classDate')";
				mysqli_query($conn, $sql1);
			}
			
			echo "<script>alert('Registered Successfully !!');</script>";
			header("Refresh: 0");
		} else {
			$message = "Error Occured !!";
		}
	}

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
		  		<div class="sidebar content-box" style="display: none;">
                <ul class="nav">
                    <!-- Main menu -->
                    <li><a href="index.php"><i class="glyphicon glyphicon-tasks"></i> Batch</a></li>
					<li  class="current"><a href="student_registration.php"><i class="glyphicon glyphicon-tasks"></i> Registration</a></li>
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
							<div class="panel-title">Student Registration</div><br />
							<?php if($message != '') { ?><button style="width:100%;" class="btn btn-danger btn-sm"><?php echo $message; ?></button><?php } ?>
						</div>
		  				<div class="panel-body">
						
						<form action="" method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="col-sm-6">
										<label>Full Name</label>
										<input type="text" value="<?php if(isset($_POST['full_name'])){ echo $_POST['full_name']; } ?>" class="form-control" required name="full_name" placeholder="Full Name">
									</div>
									<div class="col-sm-6">
										<label>Gender</label><br />
										<p>
			  							<select class="selectpicker" name="gender">
										    <option value="Male">Male</option>
										    <option value="Female">Female</option>
										  </select>
			  						</p>
									</div>
								</div>

								<hr>
								<div class="row">
									<div class="col-sm-6">
										<label>Mobile Number</label>
										<div class="input-group  col-sm-12">
											<input type="text" value="<?php if(isset($_POST['mobile_number'])){ echo $_POST['mobile_number']; } ?>" class="form-control" required name="mobile_number" data-mask="999-999-9999" data-mask-placeholder="X">
										</div>
									</div>
									<div class="col-sm-6">
										<label>Email Id</label>
										<input type="email" value="<?php if(isset($_POST['email_id'])){ echo $_POST['email_id']; } ?>" class="form-control" required name="email_id" placeholder="Email Id">
									</div>
								</div>

								<hr>
								
								<div class="row">
									<div class="col-sm-6">
										<label>Language</label>
										<input type="text" value="<?php if(isset($_POST['language'])){ echo $_POST['language']; } ?>" class="form-control" required name="language" placeholder="Language">
									</div>
									<div class="col-sm-6">
										<label>Country</label>
										<div class="bfh-selectbox bfh-countries" data-country="IN" data-name="country" data-flags="true"></div>
									</div>
								</div>

								<hr>
								<div class="row">
									<div class="col-sm-6">
										<label>Date Of Birth</label>
										<div class="input-group col-sm-12">
											<input type="text" value="<?php if(isset($_POST['dob'])){ echo $_POST['dob']; } ?>" class="form-control mask-date" required name="dob"  placeholder="Date Of Birth" data-mask="9999-99-99" data-mask-placeholder="-">
										</div>
									</div>
									<div class="col-sm-6">
										<label>Attach Your ID</label>
										<input type="file" name="identification_id" required class="btn btn-default" id="exampleInputFile1">
									</div>
								</div>
								
								<hr>
								<div class="row">
									<div class="col-sm-6">
										<label>Select A Batch</label>
										<p>
			  							<select class="selectpicker" name="batch_id">
										<?php  while($row = mysqli_fetch_assoc($result)) { ?>
										    <option value="<?php echo $row['id']; ?>"><?php echo $row['batch_number']; ?></option>
										<?php } ?>
										  </select>
										</p>
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