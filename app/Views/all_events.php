<?php
use App\Models\Event_model;

$n_dash = true;


$e_model = new Event_model();
$events = $e_model->get_all_events();
$attend_btn = true;

include('top.php');
$events_obj = (object)[
    "title" => "All Events",
    "events" => $events
];
?><div class="row ">
<div class="col-1"></div>
<div class=" col-10">
<?php
include('includes/event_listing.php');
?> </div>
</div>
<?php
include('bottom.php');