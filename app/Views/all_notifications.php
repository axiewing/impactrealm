<?php

use App\Models\Event_model;
use App\Models\Notification_model;

$side_nav = true;

$n_model = new Notification_model();
$notifications = $n_model->my_notifications(100);
//echo json_encode($evs);
include('top.php');

?>
<div class="container-fluid p-0" style="min-height: 70vh;">

    <div class="row">
        <div class="foc p-3">
            <?php if ($notifications) { ?>
                <div class="col-11 p-3">
                    <?php foreach ($notificantions as $ind => $notif) {
                    ?>
                        <div id="notif<?php echo $notif['id']; ?>" class=" p-3">
                            <button onclick="seen_it(<?php echo $notif['id']; ?>)" class="btn bg-dark float-end "><span class="text-danger">X</span></button>

                            <h6 class="fw-normal mb-0"><?php echo $notif["msg"]; ?></h6>
                            <h6 class="fw-normal mb-0"><?php echo $notif["content"]; ?></h6>
                            <small><?php echo $notif["des"]; ?></small>
                            <hr class="dropdown-divider">
                        </div>


                    <?php
                    } ?>
                </div>

            <?php } ?>
        </div>
    </div>
</div>
<script>
    function seen_it(n_id) {
        $.get("<?php echo base_url(); ?>/seen/" + n_id, function(data, status) {
            if (status == 'success') {
                $("#notif" + n_id).hide();
            } else {
                alert("failed");
            }
        });
    }
</script>
<?php




include('bottom.php');
?>