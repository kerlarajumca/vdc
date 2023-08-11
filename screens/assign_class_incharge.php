<?PHP
include_once("header.php");

if (isset($_POST['submit'])) {
  $class = $_POST['class'];
  $faculty = $_POST['faculty'];
  if (mysqli_query($conn, "Insert into class_incharge(facultyid,classid) values($faculty,$class)")) {
    echo '<script>alert("Class Assigned Successfully")</script>';
    header("Refresh:0");
  } else {
    echo '<script>alert("Something Went Wrong")</script>';
  }
  unset($_POST);
}
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
              <p class="m-0">Assign Class Incharge </p>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Assign Class Incharge</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <form action="#" method="post">
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card card-primary">
                <div class="card-header">
                  <div class="card-title">Select Class</div>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exforcourse">Select Course</label>
                    <select class="form-control course" id="exforcourse" name="course" required>
                      <option value="">Select Course</option>
                      <?PHP
                      $course_sql = mysqli_query($conn, "select * from courses");

                      while ($row = mysqli_fetch_array($course_sql)) {

                        echo "<option value=" . $row['id'] . ">" . $row['course'] . "</option>";
                      }
                      ?>

                    </select>

                  </div>
                  <label for="exforgroup">Select Group</label>
                  <select class="form-control groupid" id="exforgroup" name="group" required>
                    <option value="">Select Group</option>
                  </select>

                  <label for="exforgroup">Select Class</label>
                  <select class="form-control classid" id="exforgroup" name="class" required>
                    <option value="">Select Class</option>
                  </select>

                </div>


              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="card card-danger">
                <div class="card-header">
                  <div class="card-title">Select Faculty</div>
                </div>
                <div class="card-body">
                  <?PHP
                  $q = mysqli_query($conn, "select * from departments order by dept_name");
                  ?>

                  <label>Deprtments</label>

                  <select name="deptid" placeholder="Select Deprtment" class="form-control deptid" required />
                  <option value="">Select Deprtment </option>
                  <?PHP
                  while ($r = mysqli_fetch_array($q)) {
                    echo "<option value='" . $r['id'] . "'>" . $r['dept_name'] . "</option>";
                  }
                  ?>
                  </select>


                  <label for="exforgroup">Select Faculty</label>
                  <select class="form-control facultyid" id="exforgroup" name="faculty" required>
                    <option value="">Select Faculty</option>
                  </select>
                  <div class="form-group">
                    <input type="submit" name="submit" value="Assign" class="btn btn-success form-control" />
                  </div>
                  
                </div>
              </div>
            </div>

            
          </div>
          </form>
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
  <script src="../plugins/jquery/jquery.min.js"></script>
  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../plugins/jszip/jszip.min.js"></script>
  <script src="../plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>



  <script>
    $(function() {
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');





    });

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
          url: 'APIS/get_free_classes.php',
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


    $(".deptid").on('change', function() {
      var deptid = $(this).val();
      console.log(deptid)
      if (deptid) {
        $.ajax({
          type: 'POST',
          url: 'APIS/get_faculties.php',
          data: {
            deptid: deptid
          },
          success: function(htmlresponse) {
            var json = $.parseJSON(htmlresponse)

            var len = json.length;
            console.log(json)
            item = "<option value=''>Select Class</option>";
            for (var i = 0; i < len; i++) {
              item += "<option value=" + json[i]['fid'] + ">" + json[i]['faculty'] + "</option>";

            }
            $(".facultyid").html(item);
          }
        });
      }
    });
  </script>

  <div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Group</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <?PHP
            $q = mysqli_query($conn, "select * from courses");

            ?>

            <div class="row">
              <div class="col-6">
                <label>Course</label>
              </div>
              <div class="col-6">
                <select name="course" placeholder="Select Course Name" class="form-control" required />
                <?PHP
                while ($r = mysqli_fetch_array($q)) {
                  echo "<option value='" . $r['id'] . "'>" . $r['course'] . "</option>";
                }
                ?>
                </select>
              </div>

            </div>


            <div class="row">
              <div class="col-6">
                <label>Group</label>
              </div>
              <div class="col-6">
                <input type="text" name="group" class="form-control" placeholder="Enter Course Name" required />
              </div>

            </div>

          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" name="submit" value="Save" />
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

</body>

</html>