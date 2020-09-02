<?php
session_start();
include('config/database.php');
if(isset($_POST['login'])){
  if($_POST['username'] !=='' && $_POST['password'] !==''){
    $userName = $_POST['username'];
    $password = md5($_POST['password']);
    $getLogin = "select first_name,last_name from user where user_name='$userName' and password='$password'";
    $result = mysqli_query($con,$getLogin);
    $row = mysqli_num_rows($result);
    $rowData = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if($row > 0){
      $_SESSION['login'] =true;
      $_SESSION['first_name']= $rowData['first_name'];
      $_SESSION['last_name']= $rowData['last_name'];
      /*We dont have full permission for settup the cron, once you setup the cron job remove the below update query. cronjob file path(cron/autoclose.php)*/
      date_default_timezone_set('Asia/Dubai');
      $date = date('Y-m-d');
      $autoClose = "update book_appointment set reason='Auto close',status=2  where appointment_date < '$date'";
      $result = mysqli_query($con,$autoClose);
      header('Location:dashboard.php');
    } else {
      $_SESSION['msg']= "Invalid username or password!!";
    }

  } else {
    $_SESSION['msg']= "Username and password is requierd!!";
  }
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"
    />

    <link
      href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" type="text/css" href="../student/css/style.css" />
    <title>Appointment</title>
  </head>
  <body>
    <div class="d-flex flex-column h-100">
      <header>
        <div class="top-nav container-fluid">
          <div class="top-bar d-flex h-100">
            <div class="top-left-contact h-100">
              <ul>
                <li>Call Us Today! +9714 4431124</li>
                <li>info@qhseinternational.com</li>
              </ul>
            </div>
            <div class="social-links ml-auto">
              <ul>
                <li><i class="fa fa-facebook" aria-hidden="true"></i></li>
                <li><i class="fa fa-twitter" aria-hidden="true"></i></li>
                <li><i class="fa fa-instagram" aria-hidden="true"></i></li>
                <li><i class="fa fa-linkedin" aria-hidden="true"></i></li>
                <li><i class="fa fa-youtube-play" aria-hidden="true"></i></li>
                <li><i class="fa fa-whatsapp" aria-hidden="true"></i></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="main-navigation container-fluid">
          <div class="logo pt-2 b-2">
            <img src="../student/img/QHSE-High-Res-e1585043114574.png" />
          </div>
          <div class="menu ml-auto"></div>
        </div>
      </header>
      <div class="container pt-4 pb-1">
        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" id="inputEmailAddress" type="email" placeholder="Enter email address" name="username"/>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password" name="password"/>
                                            </div>
                                           
                                            <div class="form-group align-items-center">
                                               <?php if(isset($_SESSION['msg']) &&$_SESSION['msg'] !=='') {
                                                  echo '<span class="error">'.$_SESSION['msg'].'</span><br/>';
                                               }?>

                                               <button type="submit" class="btn btn-primary" name="login">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
      </div>
      <footer class="footer mt-auto">
        <div class="top-nav container-fluid">
          <div class="top-bar d-flex h-100">
            <div class="top-left-contact h-100">
              <ul>
                <li>Call Us Today! +9714 4431124</li>
                <li>info@qhseinternational.com</li>
              </ul>
            </div>
            <div class="social-links ml-auto">
              <ul>
                <li><i class="fa fa-facebook" aria-hidden="true"></i></li>
                <li><i class="fa fa-twitter" aria-hidden="true"></i></li>
                <li><i class="fa fa-instagram" aria-hidden="true"></i></li>
                <li><i class="fa fa-linkedin" aria-hidden="true"></i></li>
                <li><i class="fa fa-youtube-play" aria-hidden="true"></i></li>
                <li><i class="fa fa-whatsapp" aria-hidden="true"></i></li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </body>
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"
  ></script>
  <script
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"
  ></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

  <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"
  ></script>
</html>
