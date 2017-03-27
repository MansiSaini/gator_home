<div class="container">
    <h2 align="center">Login</h2>
    <div class='col-md-3'>
    </div>
    <div class='col-md-6'>
        <form action="<?php echo URL; ?>login/verifyUser" method="POST">
        <p>
            <label for='username' class="form-control-label">UserName:</label>
            <input class="form-control" type='text' name='uname' id='username' maxlength="50" required/>
         </p>
         <p>
            <label for='password' class="form-control-label">Password:</label>
            <input class="form-control" type='password' name='password' id='password' maxlength="50" required/>
        </p>
        <center><?php if (isset($errorMessage)) { ?> <label class="error error-color"> <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?> </label> <?php } ?></center>
        <center>
        <input type="hidden" name="referer" value="<?php if (isset($httpReferer)) echo $httpReferer; else echo $_SERVER['HTTP_REFERER']; ?>" />
        <input type='submit' class='btn btn-success' style="background-color:#33cccc;" name='submit_login_user' value='Submit' />
        </form>
        <p>
          <small>
            Do not have an account ? Register <a href="<?php echo URL; ?>register">here</a>
          </small>
        </p>
        </center>
    </div>
</div>