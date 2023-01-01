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
<div class="row landing_banner" >
    <h1 class="ps-5  text-uppercase">Discover, Create and Manage Web3 Gaming Events.</h1>
    <a  class="mx-auto mt-auto" href="<?php echo base_url(); ?>/new-event">
        <button  class="text-white bg-transparent  p-3">Create an Event</button>
    </a>
</div>

<div class="container-fluid p-0">

    <div class="row">
        <div class="foc">
            <?php
            $events_obj = (object)[
                "title" => "Discover",
                "events" => $events
            ];

            include('includes/event_listing.php');
            ?> </div>
    </div>
    <?php

    include('includes/how_section.php');



    ?>
</div>
<?php
include('bottom.php');

?>