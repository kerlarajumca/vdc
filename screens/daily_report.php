<?PHP
include_once("header.php");

$result = array();
$subj = "";
$datesarr1 = array();
$studsarr1 = array();
$fid=$_SESSION['facultyid'];
$fname=$_SESSION['user'];
$tdate="";

$gdeptq=mysqli_query($conn,"select U.deptid,D.dept_name from users U left join departments D on U.deptid=D.id where U.id=$fid ");
$dr=mysqli_fetch_array($gdeptq);
$department=$dr['dept_name'];
if (isset($_POST['get_data'])) 
{
    $tdate=$_POST['tdate'];
    $facultyid = $_SESSION['facultyid'];
    $recid = array();

    $datesq = mysqli_query($conn, "select A.*,C.class_name,S.subj_code from attendance A left join classes C on A.classid=C.id left join subjects S on A.subject=S.id where A.tdate='$tdate' and A.faculty=$facultyid order by A.hour asc");
    while ($r = mysqli_fetch_array($datesq)) {
    $tarr = array(
        "recid" => $r['recid'],
        "hour" => $r['hour'],
        "topic"=>$r['topic'],
        "class"=>$r['class_name'],
        "subj_code"=>$r['subj_code']
    );
    array_push($datesarr1, $tarr);
    } 
}
?>
<style type="text/css">
    @media print {
    td {
        white-space: pre-wrap;
    }
}
</style>
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
                                            <label for="exforcourse">Select Date</label>
                                            <select class="form-control course" id="exforcourse" name="tdate" required>
                                                <option value="">Select Date</option>
                                                <?PHP
                                                    $dates_sql ="select tdate from attendance where faculty=$fid";
                                                    $dates_sql.=" and MONTH(tdate) = MONTH(now()) and YEAR(tdate) = YEAR(now()) group by tdate order by tdate desc";
                                                                    
                                                    $dexec=mysqli_query($conn,$dates_sql);
                                                    while ($row = mysqli_fetch_array($dexec)) {
                    
                                                                        echo "<option value=" . $row['tdate'] . ">" . $row['tdate'] . "</option>";
                                                                    }
                                                
                                                ?>

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
                            <div class="card-title">Faculty Daily Report</div>
                        </div>
                        <div class="card-body">
                            <?php
                             

                            if(empty($datesarr1)) {
                                
                                echo "You dont have";
                            } 
                            else 
                            {
                                
                            ?>
                                <table class="table table-stripped" id="example2">
                                    <thead>
                                        <tr>
                                            <th>Faculty Name: </th>
                                            <th><?PHP echo $fname;?></th>
                                            <th>&nbsp;</th>
                                            <th>Department:  </th>
                                            <th><?PHP echo $department; ?></th>
                                            <th> &nbsp;</th>
                                           
                                            <th>Date: <?PHP echo $tdate; ?></th>
                                        
                                            
                                        </tr>
                                       
                                    </thead>
                                    <tbody>
                                    <tr>
                                            <td>SNO</td>
                                            <td>Hour</td>
                                            <td>Class</td>
                                            <td>Subject</td>
                                            <td>Topic</td>
                                            <td>Present/Absent</td>
                                            
                                            <td>Absents</td>
                                        </tr>
                                        <?PHP
                                        $n = 1;
                                        foreach ($datesarr1 as $d) {
                                            $recid=$d['recid'];
                                            $q2=mysqli_query($conn,"select * from attendance_detail where recid=$recid and status=1 order by studentid asc");
                                            $pcount=mysqli_num_rows($q2);

                                            $q3=mysqli_query($conn,"select AD.*,S.admn_no from attendance_detail AD left join students S on AD.studentid=S.id where recid=$recid and status=0 order by studentid asc");
                                            $absentees="";
                                            $abcount=mysqli_num_rows($q3);
                                            if($abcount>0)
                                            {
                                                while($r2=mysqli_fetch_array($q3))
                                                {
                                                    if($absentees=="")
                                                    {
                                                        $absentees=$r2['admn_no'];
                                                    }
                                                    else
                                                    {
                                                        $absentees.=",".substr(trim($r2['admn_no']),-3);
                                                    }
                                                }
                                            }
                                            else{
                                                $absentees="No Absentees....";
                                            }  
                                            $absentees.=",564,342,231,456,896,564,234,876,762,098,234,342";
                                            $absentees.=",564,342,231,456,896,564,234,876,762,098,234,342";
                                            $absentees.=",564,342,231,456,896,564,234,876,762,098,234,342";
                                            $absentees.=",564,342,231,456,896,564,234,876,762,098,234,342";
                                            ?>
                                            <tr>
                                                <td width=10px><?PHP echo $n; ?></td>
                                                <td><?PHP echo $d['hour']?></td>
                                                <td><?PHP echo $d['class']?></td>
                                                <td><?PHP echo $d['subj_code'] ?></td>
                                                <td><?PHP echo wordwrap($d['topic'],25,"<br>\n",true) ?></td>
                                                <td><?PHP echo $pcount."/".$abcount ?></td>
                                                <td><?PHP echo wordwrap($absentees,30,"<br>\n",true) ?></td>
                                            </tr>
                                            <?PHP

                                           
                                            $n++;
                                                                 
                                               
                                        }
                                       
                                        
                                        ?>
                                         <tr height="50px">
                                            <td>Faculty Sign:</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>Head Of Dept Sign:</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>Principal</td>
                                        </tr>
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
         $(document).ready(function() {
        document.title = "Vaagdevi Degree & P.G College | Hanamkonda | Daily Report of Staff";
    });

        $(function() {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
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