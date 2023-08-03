<?PHP
include_once("header.php");
$courses = mysqli_query($conn, "select * from courses");
$result = array();
if (isset($_POST['get_data'])) {
    $course = $_POST['course'];
    $group = $_POST['group'];
    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $clsdate = $_POST['clsdate'];
    $facultyid = $_SESSION['facultyid'];
    $recid = array();
    $sql1 = "select recid from attendance where faculty=$facultyid and classid=$class and subject=$subject and tdate='$clsdate' ";

    if ($res = mysqli_query($conn, $sql1)) {
        $c = mysqli_num_rows($res);
        if ($c != 0) {
            while ($r = mysqli_fetch_array($res)) {
                array_push($recid, $r['recid']);
            }
        }
    }

    if (empty($recid)) {
        echo "<script type='text/javascript'>alert('No Record Found!');</script>";
    } else {

        foreach ($recid as $value) {
            $rid = $value;
            $tmp = array("recid" => $value, "attendance" => array());
            $sql2 = "select A.studentid,A.status,S.sname,S.admn_no from attendance_detail A left join students S on S.id=A.studentid where A.recid='$value'";
            $r = mysqli_query($conn, $sql2);
            $attandance = array();
            while ($row = mysqli_fetch_array($r)) {
                $arr = array(
                    "sid" => $row['studentid'],
                    "status" => $row['status'],
                    "admn_no" => $row['admn_no'],
                    "sname" => $row['sname']
                );
                array_push($tmp['attendance'], $arr);
            }
            //array_push($tmp['attendance'], $attandance);
            array_push($result, $tmp);
        }
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

                                        <div class="form-group date-div">
                                            <label for="exfordate">Select Date</label>
                                            <input class="custom-select form-control-border dateid" type="date" id="exfordate" name="clsdate" value="<?PHP echo date("Y-m-d"); ?>" required>

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
                            <div class="card-title">Students attendance</div>
                        </div>
                        <div class="card-body">
                            <?PHP
                            if (isset($_POST['get_data']) && empty($result)) {
                                echo "No results found";
                            }
                            if (isset($_POST['get_data']) && !empty($result)) {
                                foreach ($result as $r1) {
                                    
                                    $recordid = $r1['recid'];
                                    $details = $r1['attendance'];
                                    $n=1;
                                    ?>
                                    <h2><?PHP echo $recordid; ?></h1>
                                            <table class="table table-bordered table-havor example2">
                                                <thead>
                                                    <tr>
                                                        <th>SNO</th>
                                                        <th>Name</th>
                                                        <th>Admin No</th>
                                                        <th>Attendance</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?PHP
                                    foreach ($details as $det) {
                                        
                            ?>
                                                <tr style=<?PHP echo $det['status']==1?"color:green":"color:red";?> >
                                                    <td><?php echo $n; ?>
                                                    <td><?php echo $det['sname'];?></td>
                                                    <td><?PHP echo $det['admn_no']; ?></td>
                                                    <td><?php echo $det['status']==1?"Present":"Absent"; ?></td>
                                    </tr>

                                                
                                <?PHP
                                $n++;
                                    }
                                    ?>
                                    </tbody>
                                            </table>
                                            <hr>
                                            <?PHP
                                }
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
            $('.example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('.example2_wrapper .col-md-6:eq(0)');
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