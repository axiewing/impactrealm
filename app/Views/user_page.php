<?php
use App\Models\Event_model;

$n_dash = true;


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
</div>
<?php
include('bottom.php');