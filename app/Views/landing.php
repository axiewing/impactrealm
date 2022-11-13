<?php
use App\Models\Event_model;

$e_model = new Event_model();
$events = $e_model->get_ten_events();
$n_dash = true;
$attend_btn = true;
$landing_page = true;
//echo json_encode($evs);
include('top.php');

?>
<div class="row align-items-center " >
    <img class="landing_banner" src="img/gaming.webp" />
<h2 style="position: absolute;" class="ps-5 col-12">Discover, Create and Manage Web3 Gaming Events.</h2>
</div>
<div class="row ">
    <div class="text-center">
    <a href="<?php echo base_url();?>/new-event"><button class="btn btn-primary m-4 p-3">Create an Event</button></a>
    </div>
</div>

<?php
$events_obj = (object)[
    "title" => "Popular Events Among Gamers",
    "events" => $events
];

include('includes/event_listing.php');
include('includes/divider.php');
include('includes/how_section.php');
include('includes/divider.php');

include('bottom.php');

?>