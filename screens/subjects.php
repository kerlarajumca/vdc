<?PHP
include_once("header.php");
$subjects=mysqli_query($conn,"Select C.course,G.group_name,CL.class_name,S.id,S.subj_code,S.subj_title from subjects S left join classes CL on S.classid=CL.id left join groups G on CL.group_id=G.id left JOIN courses C on G.course_id=C.id");

if(isset($_POST['submit']))
{
   
    $course=$_POST['course'];
    $group=$_POST['group'];
    $class1=$_POST['class'];
    $subjcode=$_POST['subjcode'];
    $subjtitle=$_POST['subjtitle'];
    
    if(mysqli_query($conn,"Insert into subjects(classid,subj_code,subj_title) values($class1,'$subjcode','$subjtitle')"))
    {
        echo '<script>alert("subject Successfully")</script>';
        //echo '<script>alert("'.mysqli_error($conn).'")</script>';
        header("Refresh:0");
    }
    else
    {
        echo '<script>alert("Something Went Wrong")</script>';
    }
    unset($_POST);
}
?>

<body class="hold-transition sidebar-mini layout-fixed" >
<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<div class="wrapper" >

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
            <p class="m-0">Subjects &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
                  Add New
                </button>
            </p>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Subjects</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">Subjects</div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-havor" id="example2">
                   <thead>
                    <tr>
                        <th>SNO</th>
                        <th>Course</th>
                        <th>Group</th>
                        <th>Class</th>
                        <th>Subject Code</th>
                        <th> Subject</th>
                        
                    </tr>
                   </thead>
                   <tbody>
                    <?PHP 
                      $sno=1;
                      while($r=mysqli_fetch_array($subjects))
                      {
                        $course=$r['course'];
                        $group=$r['group_name'];
                        $class=$r['class_name'];
                        $subjcode=$r['subj_code'];
                        $subj=$r['subj_title'];
                        
                        echo "<tr>
                          <td>$sno
                            &nbsp; &nbsp; <button class='btn btn-warning btnedit' data-courseid='".$r['id']."' data-toggle='modal' data-target='#modal-lg'>Edit </button>
                            &nbsp; &nbsp;  <button class='btn btn-danger del' data-recid='".$r['id']."'>Delete </button>
                          </td>
                          
                          <td>$course</td>
                          <td>$group</td>
                          <td>$class</td>
                          <td>$subjcode</td>
                          <td>$subj</td>
                        </tr>
                        ";
                        $sno++;
                      }
                    ?>
                   </tbody>
                </table>
            </div>
        </div>
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
    $(function () {
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



    $(".del").on('click', function() {
        var result = confirm("Really do you Want to delete?");
        if(result)
        {
            var recid = $(this).data('recid')
        console.log(recid)
        if (recid) {
          $.ajax({
            type: 'POST',
            url: 'APIS/delete_record.php',
            data: {
              recid: recid,
              table:'subjects',
              colname:'id'
            },
            success: function(htmlresponse) {
              var json = $.parseJSON(htmlresponse)
              alert(json[0]['msg']);
              location.reload();
              
              
            }
          });
        }
        }

     
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




});



</script>

<div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add New Subject</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="post">
            <div class="modal-body">
                <?PHP
                $q=mysqli_query($conn,"select * from courses");
                 
                ?>
              
              <div class="row">
                    <div class="col-6">
                        <label>Courses</label>
                    </div>
                    <div class="col-6">
                        <select name="course" placeholder="Select Course" class="form-control course" required />
                        <option value="">Select Course </option>
                        <?PHP
                          while($r=mysqli_fetch_array($q))
                          {
                            echo "<option value='".$r['id']."'>".$r['course']."</option>";
                          }
                        ?>
                        </select>
                    </div>

                </div>


                <div class="row">
                    <div class="col-6">
                        <label>Select Group</label>
                    </div>
                    <div class="col-6">
                    <select class="form-control groupid" id="exforgroup" name="group" required>
                <option value="">Select Group </option>    
                </select>
                    </div>

                </div>

                <div class="row">
                    <div class="col-6">
                        <label>Select Class</label>
                    </div>
                    <div class="col-6">
                    <select class="form-control classid" id="exforgroup" name="class" required>
                <option value="">Select Class </option>    
                </select>
                    </div>

                </div>

                
                <div class="row">
                    <div class="col-6">
                        <label>Subject Short Code</label>
                    </div>
                    <div class="col-6">
                        <input type="text" name="subjcode" class="form-control" placeholder="Enter subject code" required />
                    </div>

                </div>


                <div class="row">
                    <div class="col-6">
                        <label>Subject Title</label>
                    </div>
                    <div class="col-6">
                        <input type="text" name="subjtitle" class="form-control" placeholder="Enter subject title" required />
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