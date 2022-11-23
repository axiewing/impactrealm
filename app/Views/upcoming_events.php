<?php

use App\Models\Event_model;

$upcoming_page = true;
$side_nav = true;

$e_model = new Event_model();
$events = $e_model->get_attending_events();
$attend_btn = true;
//echo json_encode($evs);
include('top.php');


?>
<div class="container-fluid p-0">

    <div class="row">
        <div class="foc">
            <?php

            $events_obj = (object)[
                "title" => "Events to be Attended by you",
                "events" => $events
            ];
            include('includes/event_listing.php');
            ?> </div>
    </div>
</div>
<?php


include('bottom.php');
?>