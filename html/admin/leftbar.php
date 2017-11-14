<!--sidebar left start-->
<aside class="sidebar sidebar-left">
    <div class="sidebar-profile">
        <div class="avatar">
            <img class="img-circle profile-image" src="<?php echo IMG_PATH;?>owner-icon.png" alt="profile">
        </div>
        <div class="profile-body dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><h4><?php echo $_SESSION['admin_full_name'];?><span class="caret"></span></h4></a>
            <small class="title">Admin Account</small>
            <ul class="dropdown-menu animated fadeInRight" role="menu">
                <li>
                    <a href="javascript:void(0);">
                        <span class="icon"><i class="fa fa-user"></i>
                        </span>Admin Account</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo ADMIN_SITE_URL;?>change-password.php">
                        <span class="icon"><i class="fa fa-user"></i>
                        </span>Change Password</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo ADMIN_SITE_URL;?>logout.php">
                        <span class="icon"><i class="fa fa-sign-out"></i>
                        </span>Logout</a>
                </li>
            </ul>
        </div>
    </div>
    <nav>
        <h5 class="sidebar-header">Navigation</h5>
        <ul class="nav nav-pills nav-stacked">
            <li id="dashboardPage" class="active">
                <a href="<?php echo ADMIN_SITE_URL;?>dashboard.php" title="Dashboard">
                    <i class="fa fa-fw fa-tachometer"></i> Dashboard
                </a>
            </li>
            <li id="categoriesPage">
                <a href="<?php echo ADMIN_SITE_URL;?>categories.php" title="Categories and Services">
                    <i class="fa fa-medkit fa-fw"></i>Categories & Services
                </a>
            </li>
            <li id="doctorsPage" class="nav-dropdown">
                <a href="<?php echo ADMIN_SITE_URL;?>doctors.php" title="Doctors">
                    <i class="fa fa-fw fa-edit"></i> Doctors
                </a>
            </li>
            <li id="staticPage" class="nav-dropdown">
                <a href="<?php echo ADMIN_SITE_URL;?>pages.php" title="Static Pages">
                    <i class="fa fa-fw fa-file-text"></i> Pages
                </a>
            </li>
            <li id="usersPage" class="nav-dropdown">
                <a href="<?php echo ADMIN_SITE_URL;?>users.php" title="Patients">
                    <i class="fa fa-fw fa-user"></i> Patients
                </a>
            </li>
            <li id="bookingsPage" class="nav-dropdown">
                <a href="<?php echo ADMIN_SITE_URL;?>appointments.php" title="Appointments">
                    <i class="fa fa-fw fa-user"></i> Appointments
                </a>
            </li>
        </ul>
    </nav>
</aside>
<!--sidebar left end-->