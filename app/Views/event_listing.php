<!-- Widgets Start -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <h4 class="mb-0"><?php echo $events_obj->title; ?></h4>
        <?php
        try {
            foreach ($events_obj->events as $event) {
        ?>
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="rounded border border-light">
                        <div class="text-center mt-2">
                            <img class="img-fluid mx-auto mb-4" src="img/<?php echo $event->img_name; ?>" style="width:auto;height: 200px;object-fit:contain;">
                        </div>
                        <div class="px-2 py-1">
                            <h5 class="mb-1"><?php echo $event->title; ?></h5>
                            <p><?php echo $event->time; ?></p>
                            <p><?php echo $event->cost; ?></p>
                            <p class="mb-2"><?php echo $event->address; ?></p>
                        </div>
                    </div>
                </div>
            <?php
            }
        } catch (\Throwable $th) {
            ?>
            <h2>There was some error</h2>
        <?php
        }

        ?>
    </div>
</div>
<!-- Widgets End -->