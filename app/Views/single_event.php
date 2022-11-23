<?php

$n_dash = true;

// echo json_encode($event);
include('top.php');

?><div class="row  foc">
    <div class="col-1"></div>
    <div style="min-height: 70vh;" class=" col-10">
        <?php
        if ($event == null) {
        ?> <h3 class="mt-4">Sorry this event does not exists.</h3>
        <?php
        } else {
            $date = date_create_from_format('Y-m-d H:i:s', $event["event_date"]);
        ?>
            <div class="text-center mt-2">

                <img class="img-fluid mx-auto mb-4" src="<?php echo base_url(); ?>/event_imgs/<?php echo $event["banner"]; ?>" style="width:auto;height: 400px;object-fit:contain;">

            </div>
            <div class="px-3 py-1">
                <p class="mb-0 text-primary fw-bolder fs-4">
                    <?php
                    //echo date_format($date, "D M-d h:i a"); 
                    echo date_format($date, "M d"); ?>
                </p>
                <h1 class="mb-1"><?php echo $event["title"]; ?></h1>

                <p class="my-4 text-info"><?php echo $event["content"]; ?></p>

                <p class="mt-4 text-white fw-bolder fs-5">
                    Created by:
                    <span class="text-light"> <a href="<?php echo base_url().'/user/'.$event['id']; ?>"> <?php
                                                echo $event["username"]; ?>
                    </span></a>
                </p>
                <p class="mt-4 text-white fw-bolder fs-4">
                    People Attending:
                    <span class="text-light" id='attending<?php echo $event["eid"]; ?>'>
                        <?php
                        echo $event["follow_count"]; ?></span>
                    <?php
                    if (auth()->loggedIn())
                        if ($event["e_count"] == "0") {
                    ?>
                        <button id='attend<?php echo $event["eid"]; ?>' onclick='attend_event(<?php echo $event["eid"]; ?>,true)' class="btn btn-primary m-1 ms-4 p-1">Attend</button>
                    <?php
                        } else {
                    ?>
                        <button id='attend<?php echo $event["eid"]; ?>' onclick='unattend_event(<?php echo $event["eid"]; ?>,true)' class="btn btn-light m-1 ms-4 p-1">Attending</button>
                    <?php
                        }
                    ?>
                </p>
                <h3 class="pb-3 pt-5">When and where</h3>
                <div class="row pb-5">
                    <div class=" col-lg-6 col-md-6 col-sm-12">
                        <h5>Date and time</h5>
                        <p class="mb-0 text-light fw-bolder fs-5">
                            <?php
                            echo date_format($date, "D, M-d, Y h:i a");
                            ?>
                        </p>
                    </div>
                    <div class=" col-lg-6 col-md-6 col-sm-12">
                        <h5>Location</h5>
                        <p class="my-2 text-light fw-bolder fs-5">
                            <?php echo $event["address"]; ?></p>
                    </div>
                </div>

                <h3 class="pb-3 pt-5">About this event</h3>
                <p>
                    <?php
                    echo $event["content_long"];
                    ?>
                    </p>

            <h3 class="pb-3 pt-5">Share on social media</h3>
                <button class="btn border border-light"><a target="blank" href="https://www.facebook.com/share.php?u=<?php echo urlencode( base_url().'/event/'.$event['eid']); ?>"
                    > Facebook
                    </a></button>
                <button class="btn border border-light"><a target="blank" href="https://twitter.com/intent/tweet?text=Hi, Checkout this amazing event <?php echo urlencode( base_url().'/event/'.$event['eid']); ?>"
                    > Twitter
                    </a></button>
            </div>

            <script>
    var attending = <?php
                    echo $event["follow_count"]; ?>

    function attend_event(e_id) {
        $("#attend" + e_id).attr('onclick', '');
        $.get("<?php echo base_url(); ?>/attend-event/" + e_id, function(data, status) {
            if (status == 'success') {
                attending++;

                $("#attending" + e_id).html(attending);
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
                attending--;

                $("#attending" + e_id).html(attending);
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
            
        <?php
        }
        ?>
    </div>
</div>


<?php
include('bottom.php');
