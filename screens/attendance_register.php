<?PHP
include_once("header.php");
$courses = mysqli_query($conn, "select * from courses");
$result = array();
$subj = "";
$datesarr1 = array();
$studsarr1 = array();
if (isset($_POST['get_data'])) 
{
    $course = $_POST['course'];
    $group = $_POST['group'];
    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $facultyid = $_SESSION['facultyid'];
    $recid = array();

    $datesq = mysqli_query($conn, "select * from attendance where classid=$class and subject=$subject");
    while ($r = mysqli_fetch_array($datesq)) {
        $tarr = array(
            "tdate" => $r['tdate'],
            "recid" => $r['recid'],
            "hour" => $r['hour']
        );
        array_push($datesarr1, $tarr);
    }


    $studsq = mysqli_query($conn, "select * from students where classid=$class");
    while ($r2 = mysqli_fetch_array($studsq)) {
        $tarr = array(
            "sname" => $r2['sname'],
            "admnno" => $r2['admn_no'],
            "id" => $r2['id']
        );
        array_push($studsarr1, $tarr);
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
                        <div class="card card-danger">
                            <div class="card-header">
                                <div class="card-title">Select the following</div>
                            </div>
                            <div class="card-body">
                                <form action="#" method="POST">
                                    <div class="row">
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
                                        <div class="form-group">
                                            <label for="exforgroup">Select Group</label>
                                            <select class="custom-select form-control-border groupid" id="exforgroup" name="group" required>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exforclass">Select Class</label>
                                            <select class="custom-select form-control-border classid" id="exforclass" name="class" required>
                                            </select>
                                        </div>

                                        <div class="form-group subject-div">
                                            <label for="exforsubj">Select Subject</label>
                                            <select class="custom-select form-control-border subjectid" id="exforsubj" name="subject" required>
                                            </select>
                                        </div>



                                        <div class="form-group">
                                            <label for="submitfrm">&nbsp;</label>
                                            <input type="submit" value="Get Data" id="submitfrm" name="get_data" class="btn btn-primary form-control btn-submit" />
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">Students attendance Register</div>
                        </div>
                        <div class="card-body">
                            <?php
                             

                            if(empty($datesarr1)) {
                                
                                echo "Attendance not yet started for the subject";
                            } 
                            else 
                            {
                                
                            ?>
                                <table class="table table-stripped table-havor" id="example2">
                                    <thead>
                                        <tr>
                                            <td>SNO</td>
                                            <td>Student Name</td>
                                            <td>Admn No</td>
                                            <?PHP
                                            foreach ($datesarr1 as $dt) {
                                                $time_input = strtotime($dt['tdate']);
                                                $date_input = getDate($time_input);

                                                    $d2 = $date_input['mday'] . "/" . $date_input['mon'] . "(".$dt['hour'].")";
                                                    echo "<td>$d2</td>";
                                                
                                            }
                                            ?>
                                            <td>Percentage</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?PHP
                                        $n = 1;
                                        foreach ($studsarr1 as $s) {
                                            echo "<tr>";
                                            echo "<td>$n</td>";
                                            echo  "<td>" . $s['sname'] . "</td>";
                                            echo "<td>" . $s['admnno'] . "</td>";
                                            $sid = $s['id'];
                                            $totaldays=count($datesarr1);
                                            $pcount=0;
                                            foreach ($datesarr1 as $d) 
                                            {
                                                    $recid = $d['recid'];
                                                    $q="select status from attendance_detail where recid='$recid' and studentid=$sid";
                                                   
                                                    $statusqry = mysqli_query($conn, $q);
                                                    
                                                    $count1 = mysqli_num_rows($statusqry);
                                                    if ($count1 > 0) {
                                                        $r = mysqli_fetch_array($statusqry);
                                                        $status = $r['status'];
                                                        if($status==1)
                                                          $pcount++;
                                                        $flag=($status==1?"<font color='blue'>P</font>":"<font color='red'>A</font>");
                                                        echo "<td>" . $flag. "</td>";
                                                    } else {
                                                        echo "<td><font color='red'>A</font></td>";
                                                    }
                                                
                                            }
                                            $percentage=round(($pcount/$totaldays)*100,2,PHP_ROUND_HALF_UP);
                                            echo "<td>$percentage %</td>";
                                            echo "</tr>";
                                        
                                            $n++;
                                                                 
                                               
                                        }
                                       
                                        
                                        ?>
                                    </tbody>
                                </table>
                            <?PHP
                            
                            }
                            ?>



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
        $(function() {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": true,
                "responsive": false,
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



                    }
                });
            }
        });
    </script>

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Course</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-6">
                                <label>Course Name</label>
                            </div>
                            <div class="col-6">
                                <input type="text" name="course" placeholder="Enter Course Name" required />
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