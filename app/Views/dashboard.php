<?php

use \App\Models\Event_model;
use \App\Models\User_Event_model;
use CodeIgniter\Shield\Models\UserModel;

$e_model = new Event_model();
$eu_model = new User_Event_model();
$u_model = new UserModel();

$all_events = $e_model->get_alll_events();
$all_users = $u_model->get_all_user();
$dashboard_page = true;
$side_nav = true;
include('top.php');
?>

<div style="min-height: 70vh;" class="foc container-fluid pt-4 px-4">
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
    <?php



    $admin_list = $u_model->get_admin_list();
    if (in_array(auth()->user()->id, $admin_list)) {
    ?>

        <div class="bg-secondary text-center rounded p-4 mt-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">All Users</h6>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Last Seen</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($all_users as $index => $l_user) {
                        ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $l_user->username; ?></td>
                                <td><?php echo $l_user->secret; ?></td>
                                <td><?php $date = strtotime($l_user->last_used_at);
                                    if ($date) echo date('d-m-Y H:i:s ', $date + (14 * 3600)); ?></td>
                                <td><a class="btn btn-sm btn-primary" href="<?php echo base_url() . '/user/' . $l_user->uid; ?>">Show</a>

                                    <?php
                                    $super_admin_list = json_decode($_ENV["admin.list"]);
                                    if (in_array(auth()->user()->id, $super_admin_list)) {

                                        if (in_array($l_user->uid, $admin_list)) {
                                    ?>
                                            <a class="btn btn-sm btn-danger ms-2" href="<?php echo base_url() . '/remove-admin/' . $l_user->uid; ?>">Remove admin</a>

                                        <?php
                                        } else {
                                        ?>
                                            <a class="btn btn-sm btn-primary ms-2" href="<?php echo base_url() . '/add-admin/' . $l_user->uid; ?>">Make admin</a>

                                    <?php
                                        }
                                    } ?>
                                </td>
                            </tr>

                        <?php
                        }

                        ?>

                    </tbody>
                </table>
            </div>
        </div>




        <div class="bg-secondary text-center rounded p-4 mt-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">All Events</h6>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Created by</th>
                            <th scope="col">Date and Time</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($all_events as $index => $l_event) {
                        ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $l_event["title"]; ?></td>
                                <td><?php echo $l_event["username"]; ?></td>
                                <td><?php echo $l_event["event_date"]; ?></td>
                                <td><a class="btn btn-sm btn-primary" href="<?php echo base_url() . '/event/' . $l_event["eid"]; ?>">Show</a>
                                <a class="btn btn-sm btn-danger ms-2" href="<?php echo base_url() . '/a-del-event/' . $l_event["eid"]; ?>">Delete</a>
                            </td>
                            </tr>

                        <?php
                        }

                        ?>

                    </tbody>
                </table>
            </div>
        </div>


    <?php

    } ?>






</div>




<?php include('bottom.php');
?>