<?PHP
include_once("header.php");

if (isset($_POST['Update'])) {

 //   var_dump($_POST);
  $facultyid = $_SESSION['facultyid'];
  $course = $_POST['course'];
  $group = $_POST['group'];
  $class = $_POST['class'];
  $subject = $_POST['subject'];
  $tdate = $_POST['clsdate'];
  $hour = $_POST['hour'];
  $topic = $_POST['topic'];
  $recid = $facultyid.$course.$group.$class.$subject.$hour.rand(1,3);

  $checkexist = check($conn, $class, $tdate, $hour);

  if ($checkexist == 1) {
    echo '<script>alert("Attendance already submitted...")</script>';
  } else {
    $sql = "insert into attendance(recid,tdate,faculty,classid,subject,hour,topic) values('$recid','$tdate',$facultyid,$class,$subject,$hour,'$topic')";
    if (mysqli_query($conn, $sql)) {
      $students = mysqli_query($conn, "select * from students where classid=$class");
      $flag = 0;
      while ($r = mysqli_fetch_array($students)) {
        $id=$r['id'];
        $id1 = 's'.$r['id'];
       
        if((isset($_POST[$id1]) && $_POST[$id1])=='on')
        {
          $status=1;
        }
        else{
          $status=0;
        }
        
        $inssql = "insert into attendance_detail(recid,studentid,status) values($recid,$id,$status)";
        if (mysqli_query($conn, $inssql)) {
          $flag = 0;
        } else {
          $flag = 1;
        }
      }

      if ($flag == 0) {
        echo '<script>alert("Attendance Submitted Successfully")</script>';
      } else {
        echo mysqli_error(($conn));
        echo '<script>alert("Something went wrong")</script>';
      }
    } else {
      echo '<script>alert("Something went wrong. Contact Admin")</script>';
    }

    unset($_POST);
  }
}


function check($conn1, $classid, $tdate, $hour)
{
  $sql1 = mysqli_query($conn1, "select * from attendance where tdate='$tdate' and classid=$classid and hour=$hour");
  $count = mysqli_num_rows($sql1);
  if ($count == 0)
    return 0;
  else
    return 1;
}
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../Images/vdcLogo.jpg" alt="VDCLogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <?PHP
    include_once("menus.php");
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style='background:url("../Images/naac_logo2.jpg") no-repeat;background-position:center;opacity:0.9;z-index: -1'>
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <img src="../Images/naac_logo2.jpg" width="80" height="50" />
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Student Attendance</h3>
            </div>
            <form action="#" method="post">
              <div class="card-body">
                <div class="form-group">
                  <label for="exforcourse">Select Course</label>
                  <select class="custom-select form-control-border course" id="exforcourse" name="course" required>
                    <option value="">Select Course</option>
                    <?PHP
                    $course_sql = mysqli_query($conn, "select * from courses");

                    while ($row = mysqli_fetch_array($course_sql)) {

                      echo "<option value=" . $row['id'] . ">" . $row['course'] . "</option>";
                    }
                    ?>

                  </select>
                </div>

                <div class="form-group group-div">
                  <label for="exforgroup">Select Group</label>
                  <select class="custom-select form-control-border groupid" id="exforgroup" name="group" required>
                  </select>
                </div>

                <div class="form-group class-div">
                  <label for="exforclass">Select Class</label>
                  <select class="custom-select form-control-border classid" id="exforclass" name="class" required>
                  </select>
                </div>

                <div class="form-group subject-div">
                  <label for="exforsubj">Select Subject</label>
                  <select class="custom-select form-control-border subjectid" id="exforsubj" name="subject" required>
                  </select>
                </div>

                <div class="form-group date-div">
                  <label for="exfordate">Select Date</label>
                  <input class="custom-select form-control-border dateid" type="date" id="exfordate" name="clsdate" value="<?PHP echo date("Y-m-d"); ?>" required>

                </div>

                <div class="form-group hour-div">
                  <label for="exforhour">Select Hour</label>
                  <select class="custom-select form-control-border classidid" id="exforhour" name="hour" required>
                    <option value="">Select Hour </option>
                    <?PHP
                    for ($i = 1; $i <= 10; $i++) {
                      echo "<option value=$i>$i</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group topic-div">
                  <label for="exfortopic">Topic</label>
                  <input class="custom-select form-control-border dateid" type="text" id="exfortopic" name="topic" required>

                </div>

                <div class="tbl-div">
                  <h3> Students Data </h3>
                  <table class="studtbl" border="1" width="100%">

                    <tbody>

                    </tbody>

                  </table>
                </div>

                <input type="submit" value="Update" name="Update" class="btn btn-primary btn-submit" />
              </div>

            </form>
          </div>

          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?PHP
    include_once("footer.php");
    ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="../plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="../plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="../plugins/moment/moment.min.js"></script>
  <script src="../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="../plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.js"></script>
  <script>
    jQuery(document).ready(function($) {
      $(".group-div").css("display", "none")
      $(".class-div").css("display", "none")
      $(".subject-div").css("display", "none")
      $(".hour-div").css("display", "none")
      $(".tbl-div").css("display", "none")
      $(".date-div").css("display", "none")
      $(".btn-submit").css("display", "none")
      $(".topic-div").css("display", "none")

      $(".course").on('change', function() {
        var course = $(this).val();

        if (course) {
          $.ajax({
            type: 'POST',
            url: 'APIS/get_groups.php',
            data: {
              course: '' + course + ''
            },
            success: function(htmlresponse) {
              var json = $.parseJSON(htmlresponse)
              $(".group-div").css("display", "block");
              var len = json.length;
              console.log(json)
              item = "<option value=''>Select Course</option>";
              for (var i = 0; i < len; i++) {
                item += "<option value=" + json[i]['groupid'] + ">" + json[i]['group'] + "</option>";

              }
              $(".groupid").html(item);
            }
          });
        }
      });

      $(".groupid").on('change', function() {
        var groupid = $(this).val();
        console.log(groupid)
        if (groupid) {
          $.ajax({
            type: 'POST',
            url: 'APIS/get_classes.php',
            data: {
              groupid: groupid
            },
            success: function(htmlresponse) {
              var json = $.parseJSON(htmlresponse)
              $(".class-div").css("display", "block");
              var len = json.length;
              console.log(json)
              item = "<option value=''>Select Class</option>";
              for (var i = 0; i < len; i++) {
                item += "<option value=" + json[i]['classid'] + ">" + json[i]['class'] + "</option>";

              }
              $(".classid").html(item);
            }
          });
        }
      });


      $(".classid").on('change', function() {
        var classid = $(this).val();

        if (classid) {
          $.ajax({
            type: 'POST',
            url: 'APIS/get_subjects.php',
            data: {
              classid: classid
            },
            success: function(htmlresponse) {
              var resp = $.parseJSON(htmlresponse)
              $(".subject-div").css("display", "block");
              $(".hour-div").css("display", "block");
              $(".tbl-div").css("display", "block")
              $(".date-div").css("display", "block")
              $(".btn-submit").css("display", "block")
              $(".topic-div").css("display", "block")
              var subjs = resp[0];
              var studs = resp[1];

              var len1 = subjs.length
              var len2 = studs.length
              item = "<option value=''>Select Subject</option>";
              for (var i = 0; i < len1; i++) {
                item += "<option value=" + subjs[i]['id'] + ">" + subjs[i]['subj'] + "[" + subjs[i]['subj_code'] + "]</option>";

              }
              $(".subjectid").html(item);

              var tbl = "<tr>";
              tbl += "<th>SNO</th>";
              tbl += "<th>Student Name </th>";
              tbl += "<th>Admn.No</th>";
              tbl += "<th>htno</th>";
              tbl += "<th>attendance</th>";
              tbl += "</tr>";
              var x = 1;
              for (j = 0; j < len2; j++) {
                tbl += '<tr>';
                tbl += '<td>' + x + '</td>';
                tbl += '<td>' + studs[j]['sname'] + '</td>';
                tbl += '<td>' + studs[j]['admnno'] + '</td>';
                tbl += '<td>' + studs[j]['htno'] + '</td>';
                tbl+='<td><div class="custom-control custom-switch">';
                tbl+='<input type="checkbox" name="s'+studs[j]["id"]+'" class="custom-control-input" id="'+studs[j]["id"]+'">';
                tbl+='<label class="custom-control-label" for="'+studs[j]["id"]+'">Toggle this switch element</label>';
                tbl+='</div></td>';
                //tbl += '<td> <input type="radio" name="' + studs[j]["id"] + '" value="0" checked style="margin:10px">Absent';
                //tbl += '<input type="radio" name="' + studs[j]["id"] + '" value="1" style="margin:10px">Present</td>';
                tbl += '</tr>';
                x++;
              }
              $('.studtbl').html(tbl);

            }
          });
        }
      });


    });
  </script>


</body>

</html>