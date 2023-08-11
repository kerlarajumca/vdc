<aside class="main-sidebar sidebar-dark-success elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="../Images/vdclogo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Vaagdevi Colleges</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../Images/vdclogo.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?PHP echo $_SESSION['user']; ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" id="searchid">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Masters
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?PHP
                       $sql1="select * from pages where menu_type=1 and ";
                      if($role==1)
                      {
                        $sql1.="admin=1";
                      }
                      else if($role==2)
                      {
                        $sql1.="faculty=1";
                      }
                      else if($role==3)
                      {
                        $sql1.="student=1";
                      }
                    
                     $sql1.=" order by page_order asc";
                      $msql=mysqli_query($conn,$sql1);
                      $mcount=mysqli_num_rows($msql);
                      if($mcount!=0)
                      {
                        echo "<ul class='nav nav-treeview'>";
                        while($r=mysqli_fetch_array($msql))
                        {
                            echo '<li class="nav-item">
                            <a href="'.$r['link'].'" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>'.$r['menu_text'].'</p>
                            </a>
                            </li>';
                        }
                        echo '</ul>';
                      }
                      
                    ?>
                    
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-pen"></i>
                        <p>
                            Transactions
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?PHP
                    $sql2="select * from pages where menu_type=2 and ";
                    if($role==1)
                    {
                      $sql2.="admin=1";
                    }
                    else if($role==2)
                    {
                      $sql2.="faculty=1";
                    }
                    else if($role==3)
                    {
                      $sql2.="student=1";
                    }

                    $sql2.=" order by page_order asc";
                      $msql=mysqli_query($conn,$sql2);
                      $mcount=mysqli_num_rows($msql);
                      if($mcount!=0)
                      {
                        echo "<ul class='nav nav-treeview'>";
                        while($r1=mysqli_fetch_array($msql))
                        {
                            echo '<li class="nav-item">
                            <a href="'.$r1['link'].'" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>'.$r1['menu_text'].'</p>
                            </a>
                            </li>';
                        }
                        echo '</ul>';
                      }
                      
                    ?>
                </li>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Reports
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?PHP
                    $sql3="select * from pages where menu_type=3 and ";
                    if($role==1)
                    {
                      $sql3.="admin=1";
                    }
                    else if($role==2)
                    {
                      $sql3.="faculty=1";
                    }
                    else if($role==3)
                    {
                      $sql3.="student=1";
                    }

                    $sql3.=" order by page_order asc";
                      $msql=mysqli_query($conn,$sql3);
                      $mcount=mysqli_num_rows($msql);
                      if($mcount!=0)
                      {
                        echo "<ul class='nav nav-treeview'>";
                        while($r1=mysqli_fetch_array($msql))
                        {
                            echo '<li class="nav-item">
                            <a href="'.$r1['link'].'" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>'.$r1['menu_text'].'</p>
                            </a>
                            </li>';
                        }
                        echo '</ul>';
                      }
                      
                    ?>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?PHP
                    $sql4="select * from pages where menu_type=4 and ";
                    if($role==1)
                    {
                      $sql4.="admin=1";
                    }
                    else if($role==2)
                    {
                      $sql4.="faculty=1";
                    }
                    else if($role==3)
                    {
                      $sql4.="student=1";
                    }
                      $msql=mysqli_query($conn,$sql4);
                      $mcount=mysqli_num_rows($msql);
                      if($mcount!=0)
                      {
                        echo "<ul class='nav nav-treeview'>";
                        while($r4=mysqli_fetch_array($msql))
                        {
                            echo '<li class="nav-item">
                            <a href="'.$r4['link'].'" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>'.$r4['menu_text'].'</p>
                            </a>
                            </li>';
                        }
                        echo '</ul>';
                      }
                      
                    ?>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>