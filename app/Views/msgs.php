<?php if ($msg_list) { ?>
    <div id="msg_area" class="row rounded border border-primary p-2 mx-4 my-2">
        <div class="col-11">
            <?php foreach ($msg_list as $msg) { ?>
                <p class="ps-2 mb-0"><?php echo $msg ?></p>
            <?php } ?>
        </div>
        <div class="col-1">
            <button onclick="close_msg()" class="btn bg-dark float-end "><span class="text-danger">X</span></button>
        </div>
        <script>
            function close_msg() {
                var msg_area = document.getElementById("msg_area");
                msg_area.style.display = "none";
            }
        </script>
    </div>
<?php } ?>