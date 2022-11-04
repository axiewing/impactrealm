<?php
if (auth()->loggedIn()) {
    $user_c = auth()->user();
    $u_name = $user_c->username;
    $u_status = $user_c->status;
}
//echo json_encode($user_c->status);
// $user_c->status = "admin";

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

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

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
        if ($side_nav) { ?>
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
                        <a href="./dashboard" class="nav-item nav-link <?php if($dashboard_page)echo "active";?>"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                        <a href="./upcoming-events" class="nav-item nav-link <?php if($upcoming_page)echo "active";?>"><i class="fa fa-calendar-minus me-2"></i>Events to Attend</a>
                        <a href="./past-events" class="nav-item nav-link <?php if($past_page)echo "active";?>"><i class="fa fa-calendar-check me-2"></i>Events Attended</a>
                        <a href="./my-events" class="nav-item nav-link <?php if($my_page)echo "active";?>"><i class="fa fa-calendar me-2"></i>My Events</a>
                        <a href="./new-event" class="nav-item nav-link <?php if($new_page)echo "active";?>"><i class="fa fa-calendar-plus me-2"></i>Create Event</a>
                        <a href="./settings" class="nav-item nav-link <?php if($settings_page)echo "active";?>"><i class="fa fa-wrench me-2"></i>Settings</a>
                        
                    </div>
                </nav>
            </div>
            <!-- Sidebar End -->
        <?php
        }
        ?>


        <!-- Content Start -->
        <div class="content <?php if (!$side_nav) echo "open"; ?> ">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-1 py-0">
                <?php
                if ($side_nav) { ?>
                    <a href="#" class="sidebar-toggler flex-shrink-0">
                        <i class="fa fa-bars"></i>
                    </a>
                <?php  } ?>
                <a href="./" class="navbar-brand  m-1">
                    <img src="img/logo_.png" class="logo_nav" />
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Search">
                </form>

                <div class="navbar-nav align-items-center ms-auto">



                    <?php
                    if (auth()->loggedIn()) { ?>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fa fa-bell "></i>
                                <span class="d-none d-lg-inline-flex">Notificatin</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <p class="p-3">notifications coming soon</p>   
                            <!--a href="#" class="dropdown-item">
                                    <h6 class="fw-normal mb-0">Profile updated</h6>
                                    <small>15 minutes ago</small>
                                </a>
                                <hr class="dropdown-divider">
                                <a href="#" class="dropdown-item">
                                    <h6 class="fw-normal mb-0">New user added</h6>
                                    <small>15 minutes ago</small>
                                </a>
                                <hr class="dropdown-divider">
                                <a href="#" class="dropdown-item">
                                    <h6 class="fw-normal mb-0">Password changed</h6>
                                    <small>15 minutes ago</small>
                                </a>
                                <hr class="dropdown-divider">
                                <a href="#" class="dropdown-item text-center">See all notifications</a>
                    -->
                            </div>
                        </div>
                        <a href="./dashboard" class="nav-link">
                            <i class="fa fa-home "></i>
                            <span class="d-none d-lg-inline-flex">Dashboard</span>
                        </a>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <span class="d-none d-lg-inline-flex"><?php echo $u_name; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                                <a href="#" class="dropdown-item">My Profile</a>
                                <a href="#" class="dropdown-item">Settings</a>
                                <a href="./logout" class="dropdown-item">Log Out</a>
                            </div>
                        </div>
                    <?php } else {
                    ?><a href="./login"><button class="btn btn-primary rounded-pill m-3">Login</button></a>

                    <?php
                    }
                    ?>
                </div>
            </nav>
            <!-- Navbar End -->