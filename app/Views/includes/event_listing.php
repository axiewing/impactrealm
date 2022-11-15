<!-- Widgets Start -->

<div class="container-fluid pt-4 px-4" style="min-height:70vh ;">
    <div class="row g-4">
        <div class="col-12 text-center">
            <h2 class="mb-0"><?php echo $events_obj->title; ?></h2>
        </div>

        <?php

        if (count($events_obj->events) == 0) {
            echo "<h4>There are not events to show</h4>";
        }
        foreach ($events_obj->events as $event) {
        ?>
            <div id='eview<?php echo $event["id"]; ?>'  class="col-sm-12 col-md-6 col-xl-4">
                <div class="e-box rounded border border-info">
                    <div class="text-center mt-2">
                    <a href="<?php echo base_url().'/event/'.$event["id"]?>">
                        <img class="img-fluid mx-auto mb-4" src="<?php echo base_url().'/event_imgs/'.$event["banner"]; ?>" style="width:auto;height: 200px;object-fit:contain;">
                    </a>
                    </div>
                    <div class="px-3 py-1">
                    <a href="<?php echo base_url();?>/event/<?php echo $event["id"]?>">
                        <h5 class="mb-1"><?php echo $event["title"]; ?></h5>
                    </a>
                        <p class="mb-0 text-primary">
                            <?php
                            $date = date_create_from_format('Y-m-d H:i:s', $event["event_date"]);
                            echo date_format($date, "D M-d h:i a"); ?>
                        </p>
                        <p class="mb-0 text-info"><?php echo $event["content"]; ?></p>
                        <p class="my-2"><?php echo $event["address"]; ?></p>
                        <?php if (isset($delete_btn)) {
                        ?>
                            <a onclick="return confirm('You are about to Delete an Event!!!')" href="<?php echo base_url(); ?>/del-event/<?php echo $event["id"]; ?>">
                                <button class="btn btn-danger m-1 p-1">Delete</button>
                            </a>
                        <?php
                        } ?>
                        <?php
                        if (auth()->loggedIn()) 
                        if (isset($attend_btn)) {
                            if ($event["e_count"] == "0") {
                        ?>
                                <button id='attend<?php echo $event["id"]; ?>' onclick='attend_event(<?php echo $event["id"]; ?>,true)' class="btn btn-primary m-1 p-1">Attend</button>
                            <?php
                            } else {
                            ?>
                                <button id='attend<?php echo $event["id"]; ?>' onclick='unattend_event(<?php echo $event["id"]; ?>,true)' class="btn btn-light m-1 p-1">Attending</button>
                        <?php
                            }
                        } ?>
                    </div>
                </div>
            </div>
        <?php
        }
        if (isset($landing_page)) {
        ?>

        <div class="col-12 text-center">
            <a href="<?php echo base_url(); ?>/all-events"><button class="m-0 p-0 btn btn-info ">See All Events</button></a>
        </div>
        <?php
        }
        ?>
    </div>
</div>
<!-- Widgets End -->
<script>
    function attend_event(e_id) {
                $("#attend" + e_id).attr('onclick', '');
        $.get("<?php echo base_url(); ?>/attend-event/" + e_id, function(data, status) {
            if (status == 'success') {
                $("#attend" + e_id).attr('onclick', 'unattend_event(' + e_id + ')');
                //$("#attend"+e_id).attr('');
                $("#attend" + e_id).html("Attending");
                $("#attend" + e_id).remove("btn-primary");
                $("#attend" + e_id).addClass("btn-light");
            } else {
                alert("failed");
            }
        });
    }

    function unattend_event(e_id) {
                $("#attend" + e_id).attr('onclick', '');
        $.get("<?php echo base_url(); ?>/unattend-event/" + e_id, function(data, status) {
            if (status == 'success') {
                $("#attend" + e_id).attr('onclick', 'attend_event(' + e_id + ')');
                //$("#attend"+e_id).attr('');
                $("#attend" + e_id).html("Attend");
                $("#attend" + e_id).addClass("btn-primary");
                $("#attend" + e_id).removeClass("btn-light");
                <?php
                if (isset($upcoming_page)) {
                    ?>
                    $("#eview" + e_id).hide('slow');
                    <?php
                }
                ?>
            } else {
                alert("failed");
            }
        });
    }
</script>