<?php
use \App\Models\Event_model;
use \App\Models\User_Event_model;

$e_model = new Event_model();
$eu_model = new User_Event_model();

// $all_events = $e_model->get_alll_events();
// $all_users = $e_model->get_all_user();
// echo json_encode($all_users);

$dashboard_page = true;
$side_nav = true;
include('top.php');
?>

<!-- Sale & Revenue Start -->
<div style="min-height: 70vh;" class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Events Created</p>
                    <h6 class="mb-0"><?php echo $e_model->events_created_count()[0]["create_count"]; ?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Events Attended</p>
                    <h6 class="mb-0"><?php echo $eu_model->attended_count()[0]["attended_count"]; ?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Events to Attend</p>
                    <h6 class="mb-0"><?php echo $eu_model->attending_count()[0]["attending_count"]; ?></h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sale & Revenue End -->



<?php include('bottom.php');
?>