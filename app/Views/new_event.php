<?php
$new_page = true;
$side_nav = true;
include('top.php');
?>
<div class="p-3">
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4"></div>

        <div class="col-sm-12 col-xl-8">
            <div class="bg-secondary rounded h-100 p-4">
                <form method="POST" enctype="multipart/form-data">
                    <h6 class="mb-4">Create new Event</h6>
                    <div class="mb-3">
                        <label for="title">Event Title</label>
                        <input type="text" class="form-control" placeholder="Enter title" id="title" name="title" required></input>
                    </div>
                    <div class="mb-3">
                        <label for="starttime">Strats on (date and time):</label>
                        <input type="datetime-local" id="starttime" name="starttime" required>
                    </div>
                    <div class="mb-3">
                        <label for="banner" class="form-label">Select Banner image</label>
                        <input class="form-control bg-dark" type="file" id="banner" name="banner">
                    </div>
                    <div class="mb-3">
                        <label for="shortdescription">Description</label>
                        <input type="text" class="form-control" placeholder="Enter description" id="shortdescription" name="shortdescription"></input>
                    </div>
                    <div class="mb-3">
                        <label for="longdescription">Detailed Description</label>
                        <textarea class="form-control" placeholder="Enter long description here" id="longdescription" name="longdescription" style="height:70px;"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" placeholder="Enter the place of event" id="address" name="address"></input>
                    </div>
                    <input type="submit" value="Create" class="btn btn-primary ms-2"></input>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('bottom.php');
?>
<script>
    new tempusDominus.TempusDominus(document.getElementById('example'), {});
</script>