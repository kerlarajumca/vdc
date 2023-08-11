<?PHP
include_once("header.php");
$q1=mysqli_query($conn,"select * from classes");
$count1=mysqli_num_rows($q1);
$result=array();
if($count1>0)
{
    $tarr=array();
    while($r1=mysqli_fetch_array($q1))
    {
        $classid=$r1['id'];
        $class=$r1['class_name'];
        $tarr["classid"]=$classid;
        $tarr["class"]=$class;
        $tarr['subjects']=array();
        $q2=mysqli_query($conn,"select * from subjects where classid=$classid");
        $count2=mysqli_num_rows($q2);
        if($count2>0)
        {
            $subjarr=array("subjects"=>array());
            while($r2=mysqli_fetch_array($q2))
            {
                $subjectid=$r2['id'];
                $subject=$r2['subj_title'];
                $totalclasses=0;
                $q3=mysqli_query($conn,"select * from attendance where classid=$classid and subject=$subjectid" );
                $count3=mysqli_num_rows($q3);
                if($count3>0)
                {
                    $r3=mysqli_fetch_array($q3);
                    $totalclasses=$count3;
   
                }
                $tarr1=array(
                    "subject"=>$subject,
                    "total"=>$totalclasses
                );
                array_push($subjarr['subjects'],$tarr1);

            }
            array_push($tarr['subjects'],$subjarr);
        }
        array_push($result,$tarr);
    }
    
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
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="card card-danger">
                            <div class="card-header">
                                <div class="card-title">Class Report</div>
                            </div>
                            <div class="card-body">
                               
                                    <div class="row">
                                        <div class="col-lg-12">
                                       <?PHP
                                         if(empty($result))
                                         {
                                            echo "<h1 class='bg-indigo'>No classes to show</h1>";
                                         }
                                         else{
                                            ?>
                                            <table class="table table-bordered table-havor" id="example2"> 
                                                <thead>
                                                    <tr>
                                                        <th>SNo </th>
                                                        <th>Class</th>
                                                        <th>Subjects</th>
                                                        
                                                    </tr>
                                                </thead>              
                                                <tbody>  
                                            <?PHP
                                            $n=1;
                                            foreach ($result as $value){
                                                $class=$value['class'];
                                                echo "<tr>
                                                         <td>$n</td>
                                                         <td> $class</td>";
                                                         
                                                ?>
                                                <td>
                                                    <?php
                                                      if(empty($value['subjects']))
                                                      {
                                                        echo "No Subjects Found";
                                                      }
                                                      else
                                                      {
                                                        //var_dump($value['dates'][0]);
                                                        echo "<table border=2><tr><td>SNO</td><td>Subject</td><td>total Classes</td></tr>";
                                                        $s=1;
                                                        
                                                        foreach($value['subjects'] as $r)
                                                        {
                                                            
                                                            foreach($r['subjects'] as $d1)
                                                           {
                                                            echo "<tr><td>$s</td>";
                                                             
                                                            echo "<td>".$d1['subject']."</td>";
                                                            echo "<td>".$d1['total']."</td>";
                                                            echo "</tr>";
                                                            $s++;
                                                           }
                                                        }
                                                        
                                                        echo "</table>";
                                                      }
                                                    ?>
                                                </td>
                                                    </tr>

                                                <?PHP
                                                         
                                               $n++;                                                       
                                            }
                                            echo "</tbody>";
                                            
                                         }
                                       ?>
                                       
                                        </table>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
              
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


       
       

        
    </script>

 

</body>

</html>