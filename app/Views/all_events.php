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

include('includes/event_listing.php');

include('bottom.php');