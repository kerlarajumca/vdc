<?PHP
include_once("header.php");
$faculties=mysqli_query($conn,"select U.*,D.dept_name from users U left join departments D on U.deptid=D.id where U.user_role=2 order by D.dept_name,U.fname");

if(isset($_POST['submit']))
{
    $deptid=$_POST['deptid'];
    $fname=$_POST['fname'];
    $password=md5("Faculty@vdc");
    $mobileno=$_POST['mobileno'];
    $userrole=2;
    
    if(mysqli_query($conn,"Insert into users(deptid,fname,password,mobileno,user_role) values($deptid,'$fname','$password','$mobileno',$userrole)"))
    {
        echo '<script>alert("Faculty Added Successfully")</script>';
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
            <p class="m-0">Faculties  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
                  Add New
                </button>
            </p>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Faculties</li>
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
                <div class="card-title">Faculties</div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-havor" id="example2">
                   <thead>
                    <tr>
                        <th>SNO</th>
                        <th>Department</th>
                        <th>Faculty Name</th>
                        <th>Mobile No</th>
                        
                    </tr>
                   </thead>
                   <tbody>
                    <?PHP 
                      $sno=1;
                      while($r=mysqli_fetch_array($faculties))
                      {
                        $dept=$r['dept_name'];
                        $faculty=$r['fname'];
                        $mobile=$r['mobileno'];
                        echo "<tr>
                          <td>$sno
                            &nbsp; &nbsp; <button class='btn btn-warning btnedit' data-courseid='".$r['id']."' data-toggle='modal' data-target='#modal-lg'>Edit </button>
                            &nbsp; &nbsp;  <button class='btn btn-danger del' data-recid='".$r['id']."'>Delete </button>
                          </td>
                          
                          <td>$dept</td>
                          <td>$faculty</td>
                          <td>$mobile</td>
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
              table:'users',
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

});
</script>

<div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add New Faculty</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="post">
            <div class="modal-body">
                <?PHP
                $q=mysqli_query($conn,"select * from departments order by dept_name");
                 
                ?>
              
              <div class="row">
                    <div class="col-6">
                        <label>Deprtments</label>
                    </div>
                    <div class="col-6">
                        <select name="deptid" placeholder="Select Deprtment" class="form-control" required />
                        <option value="">Select Deprtment </option>
                        <?PHP
                          while($r=mysqli_fetch_array($q))
                          {
                            echo "<option value='".$r['id']."'>".$r['dept_name']."</option>";
                          }
                        ?>
                        </select>
                    </div>

                </div>


                <div class="row">
                    <div class="col-6">
                        <label>Faculty Name</label>
                    </div>
                    <div class="col-6">
                        <input type="text" name="fname" class="form-control" placeholder="Enter Faculty Name" required />
                    </div>

                </div>

                
                <div class="row">
                    <div class="col-6">
                        <label>Mobile Number</label>
                    </div>
                    <div class="col-6">
                        <input type="number" name="mobileno" class="form-control" placeholder="Enter mobile number" title="Enter valid mobile number" pattern="[1-9]{1}[0-9]{9}" required />
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