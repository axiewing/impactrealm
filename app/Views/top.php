<?php

use App\Models\Notification_model;


if (auth()->loggedIn()) {
    $user_c = auth()->user();
    $u_name = $user_c->username;
    $u_status = $user_c->status;
    $nofication_model = new Notification_model();
    $notificantions = $nofication_model->my_notifications(5);
}
//echo json_encode($user_c->status);
// $user_c->status = "admin";

// $provider = model(setting('Auth.userProvider'));

// $provider->save($user_c);
// $user_c->setPassword("12121212");

// $provider = model(setting('Auth.userProvider'));

// $provider->save($user_c);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>IR Events</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <script>
        const base_url = "<?php echo base_url(); ?>";
    </script>

    <!-- Favicon -->
    <link href="<?php echo base_url(); ?>/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo base_url(); ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo base_url(); ?>/css/style.css?v=0.2" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <?php
        if (isset($side_nav)) { ?>
            <!-- Sidebar Start -->
            <div class="sidebar pe-4 pb-3">
                <nav class="navbar bg-secondary navbar-dark">

                    <div class="d-flex align-items-center ms-4 my-4">

                        <div>
                            <h6 class="mb-0"><?php echo $u_name; ?></h6>
                            <span><?php echo $u_status; ?></span>
                        </div>
                    </div>
                    <div class="navbar-nav w-100">
                        <a href="<?php echo base_url(); ?>/dashboard" class="nav-item nav-link <?php if (isset($dashboard_page)) echo "active"; ?>"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                        <a href="<?php echo base_url(); ?>/upcoming-events" class="nav-item nav-link <?php if (isset($upcoming_page)) echo "active"; ?>"><i class="fa fa-calendar-minus me-2"></i>Events to Attend</a>
                        <a href="<?php echo base_url(); ?>/past-events" class="nav-item nav-link <?php if (isset($past_page)) echo "active"; ?>"><i class="fa fa-calendar-check me-2"></i>Events Attended</a>
                        <a href="<?php echo base_url(); ?>/my-events" class="nav-item nav-link <?php if (isset($my_page)) echo "active"; ?>"><i class="fa fa-calendar me-2"></i>My Events</a>
                        <a href="<?php echo base_url(); ?>/new-event" class="nav-item nav-link <?php if (isset($new_page)) echo "active"; ?>"><i class="fa fa-calendar-plus me-2"></i>Create Event</a>
                        <a href="<?php echo base_url(); ?>/settings" class="nav-item nav-link <?php if (isset($settings_page)) echo "active"; ?>"><i class="fa fa-wrench me-2"></i>Settings</a>

                    </div>
                </nav>
            </div>
            <!-- Sidebar End -->
        <?php
        }
        ?>


        <!-- Content Start -->
        <div class="content <?php if (!isset($side_nav)) echo "open"; ?> ">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-1 py-0">
                <?php
                if (isset($side_nav)) { ?>
                    <a href="#" class="sidebar-toggler flex-shrink-0">
                        <i class="fa fa-bars"></i>
                    </a>
                <?php  } ?>
                <a href="<?php echo base_url(); ?>/">
                    <div class="navbar-brand  m-1">
                        <img id="top_logo" class="logo_nav" src="<?php echo base_url(); ?>/img/logo_.png" />
                    </div>
                </a>

                <div class="navbar-nav align-items-center ms-auto me-3">

                    <?php if (isset($n_dash)) {
                    ?>

                        <a target="_blank" href="https://discord.com/invite/WtGSYgMcgu" class="nav-link">

                            <span class=" ">Join us on Discord</span>
                        </a>

                        <a href="<?php echo base_url(); ?>/about"><button class="btn btn-primary rounded-pill m-3">About</button></a>
                    <?php
                    }
                    if (auth()->loggedIn()) { ?>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <span class=" ">Notification</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">

                                <?php
                                if (count($notificantions) == 0) {
                                ?>
                                    <a href="#" class="dropdown-item">
                                        <h6 class="fw-normal mb-0">No new Notifications.</h6>
                                        <small>All Good</small>
                                    </a>
                                    <?php
                                } else {

                                    foreach ($notificantions as $ind => $notif) {
                                    ?>
                                        <span  class="dropdown-item">
        
                                            <h6 class="fw-normal mb-0"><?php echo $notif["msg"]; ?></h6>
                                            <small><?php echo $notif["des"]; ?></small>
                                        </span>


                                        <hr class="dropdown-divider">
                                    <?php
                                    }
                                    ?>
                                    <a href="<?php echo base_url(); ?>/notifications" class="dropdown-item text-center">See all notifications</a>
                                <?php
                                }
                                ?>

                            </div>
                        </div>
                        <?php if (isset($n_dash)) {
                        ?>


                        <?php } ?>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <span class=" "><?php echo $u_name; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                                <a href="<?php echo base_url(); ?>/dashboard" class="dropdown-item">My Profile</a>
                                <a href="<?php echo base_url(); ?>/settings" class="dropdown-item">Settings</a>
                                <a href="<?php echo base_url(); ?>/logout" class="dropdown-item">Log Out</a>
                            </div>
                        </div>
                        
                    <?php } else {
                    ?>
                        <a href="<?php echo base_url(); ?>/login"><button class="btn btn-primary rounded-pill m-3">Login</button></a>
                        <a href="<?php echo base_url(); ?>/register"><button class="btn btn-primary rounded-pill m-3">Register</button></a>

                    <?php
                    }
                    ?>
                </div>
            </nav>
            <!-- Navbar End -->
            <?php
            if (!isset($msg_list)) {
                $msg_list = [];
            }
            include('msgs.php'); ?>