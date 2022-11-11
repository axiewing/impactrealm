<!-- Widgets Start -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12 text-center">
            <h2 class="mb-0"><?php echo $events_obj->title; ?></h2>
        </div>

        <?php
        
        if(count($events_obj->events)==0){
            echo "<h4>There are not events to show</h4>";
        }
            foreach ($events_obj->events as $event) {
        ?>
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="rounded border border-info">
                        <div class="text-center mt-2">
                            <img class="img-fluid mx-auto mb-4" src="event_imgs/<?php echo $event["banner"]; ?>" style="width:auto;height: 200px;object-fit:contain;">
                        </div>
                        <div class="px-3 py-1">
                            <h5 class="mb-1"><?php echo $event["title"]; ?></h5>
                            <p class="mb-0 text-primary"><?php
                            $date = date_create_from_format('Y-m-d H:i:s', $event["event_date"]);
                             echo date_format($date,"D M-d h:i a");?></p>
                            <p class="mb-0 text-info"><?php echo $event["content"]; ?></p>
                            <p class="my-2"><?php echo $event["address"]; ?></p>
                        <?php if (isset($delete_btn)) {
                            ?>
                            <a onclick="return confirm('You are about to Delete an Event!!!')" href="<?php echo base_url();?>/del-event/<?php echo $event["id"]; ?>" ><button class="btn btn-danger m-1 p-1">Delete</button></a>
                            <?php
                            }?>
                        </div>
                    </div>
                </div>
            <?php
            }
        ?>
        
        <div class="col-12 text-center">
            <a href="#"><button class="m-0 p-0 btn btn-info ">See All Events</button></a>
        </div>
    </div>
</div>
<!-- Widgets End -->