<?php
use App\Models\Event_model;
use CodeIgniter\Shield\Models\UserModel;

$n_dash = true;

$u_model = new UserModel();
$e_model = new Event_model();
$events = $e_model->get_user_events($user_id);
$pevents = $e_model->get_user_past_events($user_id);
$attend_btn = true;



include('top.php');
$events_obj = (object)[
    "title" => "Upcoming events by this user",
    "events" => $events
];
?><div class="row foc">
<div class="col-1"></div>
<div class=" col-10">
<?php
include('includes/event_listing.php');
$attend_btn = false;
$events_obj = (object)[
    "title" => "Past events created by this user",
    "events" => $pevents
];
include('includes/event_listing.php');
?> </div>
<?php
$admin_list = $u_model->get_admin_list();
    if (in_array(auth()->user()->id, $admin_list)) {
    ?>

        <div class="bg-secondary text-center rounded p-4 mt-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">User's Attended Events</h6>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Date and Time</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ua_events = $e_model->get_user_attended_events($user_id);
                        foreach ($ua_events as $index => $l_event) {
                        ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $l_event["title"]; ?></td>
                                <td><?php echo $l_event["event_date"]; ?></td>
                                <td><a class="btn btn-sm btn-primary" href="<?php echo base_url() . '/event/' . $l_event["eid"]; ?>">Show</a>
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


<?php
include('bottom.php');