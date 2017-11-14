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
                    <a href="<?php echo DOCTOR_SITE_URL;?>profile.php">
                        <span class="icon"><i class="fa fa-user"></i>
                        </span>Doctor Account</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo DOCTOR_SITE_URL;?>change-password.php">
                        <span class="icon"><i class="fa fa-user"></i>
                        </span>Change Password</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo DOCTOR_SITE_URL;?>logout.php">
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
                <a href="<?php echo DOCTOR_SITE_URL;?>dashboard.php" title="Dashboard">
                    <i class="fa  fa-fw fa-tachometer"></i> Dashboard
                </a>
            </li>
            <li id="usersPage" class="nav-dropdown">
                <a href="<?php echo DOCTOR_SITE_URL;?>patients.php" title="Patients">
                    <i class="fa fa-fw fa-user"></i> Patients
                </a>
            </li>
            <li id="bookingsPage" class="nav-dropdown">
                <a href="<?php echo DOCTOR_SITE_URL;?>appointments.php" title="Appointments">
                    <i class="fa fa-fw fa-user"></i> Appointments
                </a>
            </li>
            <li id="ticketsPage" class="nav-dropdown">
                <a href="<?php echo DOCTOR_SITE_URL;?>tickets.php" title="Tickets">
                    <i class="fa fa-fw fa-ticket"></i> Tickets
                </a>
            </li>
            <li id="messagePage" class="nav-dropdown">
                <a href="<?php echo DOCTOR_SITE_URL;?>message.php" title="Message">
                    <i class="fa fa-fw fa-comment-o"></i> Messages
                </a>
            </li>
        </ul>
    </nav>
</aside>
<!--sidebar left end-->