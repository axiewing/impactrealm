<?php

use CodeIgniter\Filters\CSRF;
use CodeIgniter\Shield\Models\UserModel;

$settings_page = true;
$side_nav = true;
$u_model = new UserModel();
$profile = $u_model->get_profile();
include('top.php');
?>

<div class="ms-5 mt-4">
    <div class="row mt-4 foc">

        <div class="bg-secondary rounded h-100 p-4 col-lg-6 col-md-8 col-sm-12">
            <h6 class="mb-4">Personal Details</h6>
            <form action="<?php echo base_url();?>/updateprofile" method="POST">
                <?= csrf_field() ?>
                <input hidden name="act" value="pro_update" />
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input class="form-control " value="<?php echo $profile->secret; ?>" id="email"  readonly>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input class="form-control " value="<?php echo $profile->username; ?>" id="username"  readonly>
                </div>
                <div class="mb-3">
                    <label for="fname" class="form-label">First name</label>
                    <input class="form-control "  value="<?php echo $profile->first_name;?>" id="fname" name="fname"  >
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last name</label>
                    <input class="form-control "  value="<?php echo $profile->last_name;?>" id="lname" name="lname"  >
                </div>
                <div class="mb-3">
                    <label for="discordid" class="form-label">Discord ID</label>
                    <input class="form-control "  value="<?php echo $profile->disc_id;?>" id="discordid" name="discordid"  >
                </div>
                <div class="mb-3">
                    <label for="twitterid" class="form-label">Twitter ID</label>
                    <input class="form-control "  value="<?php echo $profile->twit_id;?>" id="twitterid" name="twitterid"  >
                </div>
                <input class="btn btn-primary" type="submit" value="Update">
            </form>
        </div>

    </div>
    <div class="row mt-4 foc">

        <div class="bg-secondary rounded h-100 p-4 col-lg-6 col-md-8 col-sm-12">
            <h6 class="mb-4">Update Password</h6>
            <form method="POST">
                <?= csrf_field() ?>
                <input hidden name="act" value="pass_update" />
                <div class="mb-3">
                    <label for="psw" class="form-label">Password</label>
                    <input class="form-control " type="password" id="psw" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="-> least one number &#010;-> one uppercase and lowercase letter &#010;->at least 8 or more characters" required>
                </div>
                <input class="btn btn-primary" type="submit" value="Update">
            </form>
            <div id="message">
                <h5>Password must contain the following:</h5>
                <p id="letter" class=" m-0 invalid">A <b>lowercase</b> letter</p>
                <p id="capital" class=" m-0 invalid">A <b>capital (uppercase)</b> letter</p>
                <p id="number" class=" m-0 invalid">A <b>number</b></p>
                <p id="length" class=" m-0 invalid">Minimum <b>8 characters</b></p>
            </div>
        </div>

    </div>

</div>

<style>
    #message {
        color: #000;
        position: relative;
        padding: 20px;
        margin-top: 10px;
    }

    #message p {
        padding: 5px 35px;
        font-size: 14px;
    }

    /* Add a green text color and a checkmark when the requirements are right */
    .valid {
        color: green;
    }


    /* Add a red text color and an "x" icon when the requirements are wrong */
    .invalid {
        color: red;
    }
</style>
<script>
    var myInput = document.getElementById("psw");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");



    // When the user starts to type something inside the password field
    myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        // Validate length
        if (myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }
</script>
<?php include('bottom.php');
?>