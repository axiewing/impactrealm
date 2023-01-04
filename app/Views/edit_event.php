<?php
$side_nav = true;
include('top.php');
?>
<div class="p-3">
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4"></div>

        <div class="col-sm-12 col-xl-8">
            <div class="bg-secondary rounded h-100 p-4">
                <form action="<?php echo base_url();?>/my-events" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <h6 class="mb-4">Edit Event</h6>
                    <div class="mb-3">
                        <label for="title">Event Title</label>
                        <input type="text" class="form-control" value="<?php echo $event["title"];?>" placeholder="Enter title" id="title" name="title" required></input>
                        <input type="text" hidden value="<?php echo $event["eid"];?>" id="eid" name="eid" ></input>
                    </div>
                    <div class="mb-3">
                        <label for="starttime">Strats on (date and time):</label>
                        <input type="datetime-local" id="starttime" value="<?php echo $event["event_date"];?>" name="starttime" required>
                    </div>
                    <div class="mb-3">
                        <label for="banner" class="form-label">Select Banner image</label>
                        <input class="form-control bg-dark" type="file" id="banner" name="banner">
                    </div>
                    <div class="mb-3">
                        <label for="shortdescription">Description</label>
                        <input type="text" class="form-control" placeholder="Enter description" value="<?php echo $event["content"];?>" id="shortdescription" name="shortdescription"></input>
                    </div>
                    <div class="mb-3">
                        <label for="longdescription">Detailed Description</label>
                        <textarea class="form-control" placeholder="Enter long description here" id="longdescription" name="longdescription" style="height:70px;"><?php echo $event["content_long"];?> </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" placeholder="Enter the place of event" value="<?php echo $event["address"];?>" id="address" name="address"></input>
                    </div>
                    <input type="submit" value="Update" class="btn btn-primary ms-2"></input>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('bottom.php');
?>
