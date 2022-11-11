<?php 

use App\Models\Event_model;

$my_page = true;
$side_nav = true;

$e_model = new Event_model();
$events = $e_model->my_events();
//echo json_encode($evs);
include('top.php');


$events_obj = (object)[
    "title" => "Events Created by you",
    "events" => $events
];
$delete_btn = true;
include('includes/event_listing.php');

include('bottom.php');
?>