<!-- Widgets Start -->

<div class="container-fluid pt-4 px-4 py-3 " <?php if (!isset($landing_page)) { ?> style="min-height:70vh ;" <?php } ?>>
    <div class="row g-4">
        <div class="col-12 text-center">
            <h2 class="mb-0 text-uppercase spc2"><?php echo $events_obj->title; ?></h2>
        </div>

        <?php

        if (count($events_obj->events) == 0) {
            echo "<h4>There are not events to show</h4>";
        }
        foreach ($events_obj->events as $event) {
        ?>
            <div id='eview<?php echo $event["eid"]; ?>' class="col-sm-7 col-md-5 col-xl-3">
                <div class="e-box rounded border bg-white border-light">
                    <div class="text-center">
                        <a href="<?php echo base_url() . '/event/' . $event["eid"] ?>">
                            <img class="img-fluid mx-auto " src="<?php echo base_url() . '/event_imgs/' . $event["banner"]; ?>" style="width:auto;height: 200px;object-fit:cover;">
                        </a>
                    </div>
                    <div class="px-3 py-1 row" style="height: calc(100% - 200px);">
                        <a href="<?php echo base_url(); ?>/event/<?php echo $event["eid"] ?>">
                            <h6 class="mb-1 text-black-50 text-uppercase"><?php echo $event["title"]; ?></h6>
                        </a>
                        <p class="mb-0 text-primary">
                            <?php
                            $date = date_create_from_format('Y-m-d H:i:s', $event["event_date"]);
                            echo date_format($date, "D M-d h:i a"); ?>
                        </p>

                        <?php
                        if (isset($landing_page)) {
                        ?>
                            <p class="mb-0 text-info"><?php echo $event["author"]; ?></p>
                        <?php
                        } else {
                        ?>
                            <p class="mb-0 text-info"><?php echo $event["content"]; ?></p>
                        <?php
                        }
                        ?>
                        <p class="my-2"><?php echo $event["address"]; ?></p>
                        <?php if (isset($delete_btn)) {
                        ?>
                            <div class="mt-auto col-4">
                                <a onclick="return confirm('You are about to Delete an Event!!!')" href="<?php echo base_url(); ?>/del-event/<?php echo $event["eid"]; ?>">
                                    <button class="btn btn-danger m-1 p-1">Delete</button>
                                </a>
                            </div>
                        <?php
                        } ?>
                        <?php if (isset($edit_btn)) {
                        ?>
                            <div class="mt-auto col-3">
                                <a href="<?php echo base_url(); ?>/edit-event/<?php echo $event["eid"]; ?>">
                                    <button class="btn btn-primary m-1 p-1">Edit</button>
                                </a>
                            </div>
                        <?php
                        } ?>
                        <?php
                        if (auth()->loggedIn())
                            if (isset($attend_btn)) {
                                if ($attend_btn)
                                    if ($event["e_count"] == "0") {
                        ?>
                                <button style="width: fit-content;" id='attend<?php echo $event["eid"]; ?>' onclick='attend_event(<?php echo $event["eid"]; ?>,true)' class="btn btn-primary m-1 p-1">Attend</button>
                            <?php
                                    } else {
                            ?>
                                <button style="width: fit-content;" id='attend<?php echo $event["eid"]; ?>' onclick='unattend_event(<?php echo $event["eid"]; ?>,true)' class="btn btn-light m-1 p-1">Attending</button>
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
                <a class="ir-btn btn-lg" href="<?php echo base_url(); ?>/all-events">
                    <button  class="  text-white text-uppercase">More Events</button></a>
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