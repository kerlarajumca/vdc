<?PHP
include_once("header.php");
$fid=$_SESSION['facultyid'];
$q="Select C.Course,G.group_name,CL.class_name,U.fname,D.dept_name,CI.id,CI.classid from class_incharge CI";
$q.=" left join users U on CI.facultyid=U.id left join departments D on U.deptid=D.id";
$q.=" left join classes CL on CI.classid=CL.id left join groups G on CL.group_id=G.id";
$q.=" left join courses C on CL.course_id=C.id where CI.facultyid=$fid";
$qres = mysqli_query($conn, $q);

$result = array();
while($r=mysqli_fetch_array($qres))
{
    
    $tarr=array(
        "classid"=>$r['classid'],
        "class"=>$r['class_name'],
        "dates"=>array()
    );
    $classid=$r['classid'];
    $q2qry="select id,tdate from attendance where faculty=$fid and classid=$classid and sms_status=0 group by tdate";
    
    $q2=mysqli_query($conn,$q2qry);
    $d=array();
    while($r2=mysqli_fetch_array($q2))
    {
        $tmp=array(
            "day" => $r2['tdate'],
            "rid"=>$r2['id']
        );
        array_push($d,$tmp);
    }
    array_push($tarr['dates'],$d);
    array_push($result,$tarr);
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
                                <div class="card-title">Send SMS</div>
                            </div>
                            <div class="card-body">
                               
                                    <div class="row">
                                       <?PHP
                                         if(empty($result))
                                         {
                                            echo "<h1 class='bg-indigo'>No Classes assigned to you</h1>";
                                         }
                                         else{
                                            ?>
                                            <table class="table table-stripped"> 
                                                <thead>
                                                    <tr>
                                                        <td>SNo </td>
                                                        <td>Class</td>
                                                        <td>Pending Days</td>
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
                                                      if(empty($value['dates'][0]))
                                                      {
                                                        echo "No Pending SMS";
                                                      }
                                                      else
                                                      {
                                                        //var_dump($value['dates'][0]);
                                                        echo "<table><tr><td>SNO</td><td>Date</td><td>action</td></tr>";
                                                        $s=1;
                                                        foreach($value['dates'][0] as $d1)
                                                        {
                                                            echo "<tr><td>$s</td>";
                                                            echo "<td>".$d1['day']."</td>";
                                                            echo "<td><button class='btn btn-primary sendsms' data-rid=".$d1['day']." data-cid=".$value['classid'].">Send SMS</button></td>";
                                                            echo "</tr>";
                                                            $s++;
                                                        }
                                                        
                                                        echo "</table>";
                                                      }
                                                    ?>
                                                </td>
                                                    </tr>

                                                <?PHP
                                                         
                                                                                                      
                                            }
                                            
                                         }
                                       ?>
                                       
                                        </table>
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
            //alert("hi")
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
                        item = '<table class="table table-bordered table-havor extbl" id="example2">';
                        
                        item+='<thead>';
                        item+="<tr>";
                        item+="<th>SNO</th>";
                        item+="<th>class</th>";
                        item+="<th>Action</th>";
                        item+="</tr>";
                        item+="</thead>";
                        item+="<tbody>";
                        for (var i = 0; i < len; i++) {
                            item+="<tr>";
                            item+="<td>"+(i+1)+"</td>";
                            item+="<td>"+json[i]['class']+"</td>";
                            item+='<td><button class="btn btn-primary btn-submit2">Send SMS</button></td>';
                            item+='</tr>';
                            //item += "<option value=" + json[i]['classid'] + ">" + json[i]['class'] + "</option>";

                        }
                        item+="</tbody>";
                        item+="</table>"
                        $("#tbls").html(item);
                    }
                });
            }
        });


        $(".sendsms").on('click', function() {
            var tdate = $(this).data('rid');
            var cid=$(this).data('cid');
            //alert(cid);
            //alert(rid);
            if (tdate && cid) {
                $.ajax({
                    type: 'POST',
                    url: 'APIS/send_sms.php',
                    data: {
                       tdate:tdate,
                       cid:cid
                    },
                    success: function(htmlresponse) {
                        var json = $.parseJSON(htmlresponse)
                         
                        alert(json[0]['msg']);
                        location.reload();
                    }
                });
            }
        });

   


        
    </script>

 

</body>

</html>