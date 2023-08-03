<?PHP
require_once("database/dbconnect.php");

if(isset($_POST['submit']))
{
 $mobileno=$_POST['mobileno'];
 $password=md5($_POST['password']);

 $sql="select * from users where mobileno='$mobileno' and password='$password'";
 $execsql=mysqli_query($conn,$sql);
 $row_count=mysqli_num_rows($execsql);
 
 if($row_count==0)
 {
  echo '<script>alert("Invalid Login Details...");</script>';
 }
 else{
  session_start();
  $record=mysqli_fetch_array($execsql);
  $_SESSION['user']=$record['fname'];
  $_SESSION['facultyid']=$record['id'];
  $_SESSION['ay']="2022-2023";
  $_SESSION['role']=$record['user_role'];
  header("location: screens/dashboard.php");
 }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vaagdevi Degree & P.G College | Log in </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class=""><img src="Images/vdclogo.jpg" width="100" height="80" style="padding-right:10px;margin-left:0px"></img><img src="Images/naac_logo.jpg" style="padding-left:10px" width="130" height="80" /></a>

    </div>
    <div class="card-body">
      <p class="login-box-msg">Vaagdevi Degree & P.G College</p>

      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="mobileno" placeholder="Mobile No">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
       
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
</body>
</html>
