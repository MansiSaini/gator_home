<div class='container'>
<h2 align="center">Register</h2>
<h5 align="center" style="color:red;">All fields marked with * are required</h5>
<div class='col-md-3'>
</div>
<div class='col-md-6'>
<div class="form-signup">
    <form name="registration" id="registration" action="<?php echo URL; ?>register/createUser" method="POST">
        <div>
            <label for='name' class="form-control-label">First Name: *</label>
        </div>
        <div class='form-group'>
            <input class="form-control" type='text' name='fname' id='fname' maxlength="50" value="<?php if (isset($form_fname)) echo htmlspecialchars($form_fname, ENT_QUOTES, 'UTF-8'); ?>" required/>
        </div>

        <div>
            <label for='name' class="form-control-label">Last Name: </label>
        </div>
        <div>
            <input class="form-control" type='text' name='lname' id='lname' maxlength="50" value="<?php if (isset($form_lname)) echo htmlspecialchars($form_lname, ENT_QUOTES, 'UTF-8'); ?>"/>
        </div>

        <div>
            <label for='email' class="form-control-label">Email Address: *</label>
            <input class="form-control" type='text' name='email' id='email' maxlength="50" value="<?php if (isset($form_email)) echo htmlspecialchars($form_email, ENT_QUOTES, 'UTF-8'); ?>" required/>
            <?php if (isset($emailError)) { ?> <label class="error error-color"> <?php echo htmlspecialchars($emailError, ENT_QUOTES, 'UTF-8'); ?> </label> <?php } ?>
        </div>

        <div>
            <label for='uname' class="form-control-label">UserName: *</label>
            <input class="form-control" type='text' name='uname' id='uname' maxlength="50" value="<?php if (isset($form_user_name)) echo htmlspecialchars($form_user_name, ENT_QUOTES, 'UTF-8'); ?>" required/>
            <?php if (isset($userError)) { ?> <label class="error error-color"> <?php echo htmlspecialchars($userError, ENT_QUOTES, 'UTF-8'); ?> </label> <?php } ?>
        </div>

        <div>
            <label for='password' class="form-control-label">Password: *</label>
            <input class="form-control" type='password' name='password' id='password' maxlength="50" required/>
        </div>

        <div>
            <label for='cpassword' class="form-control-label">Confirm Password: *</label>
            <input class="form-control" type='password' name='cpassword' id='cpassword' maxlength="50" required/>
        </div>
        <div class='checkbox'>
            <label><input type="checkbox" name="termsbox" required/>I agree with the terms and conditions as given <a href="<?php echo URL ?>support/terms" target="_blank"> here </a>.</label>
        </div>
        <center>
            <div>
                <input type="submit" class='btn btn-success' style="background-color:#33cccc;" name='submit_add_user' value='Submit'/>
            </div>
            <p>
                <small>
                Already have an account ? Login <a href="<?php echo URL; ?>login">here</a>
                </small>
            </p>
        </center>
    </form>
</div>
</div>
</div>

<script>
  $(document).ready(function () {

    $('#registration').validate({
        rules: {
            fname: {
                required: true,
                lettersonly: true
            },
        
            lname: {
                lettersonly: true
            },

            email: {
                required: true,
                email: true
            },

            uname: {
                required: true
            },

            password: {
                required: true
            },

            cpassword: {
                equalTo: "#password"
            },

            termsbox: {
                required: true
            },
        },
        messages: {
            fname: {
                required: "First name is required!"
            },

            email: {
                required: "Email is required!"
            },

            uname: {
                required: "UserName is required!"
            },

            password: {
                required: "Password is required!"
            },

            cpassword: {
                equalTo: "Passwords do not match!"
            },

            termsbox: {
                required: "Please agree to the terms and conditions to register."
            },
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.css('color', '#ff0000');
        },
        submitHandler: function (form) { // for demo
            form.submit();
        },
    });
  });
</script>
