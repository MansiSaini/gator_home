<div class="container">
    <?php
        if(isset($_SESSION['is_logged_in']) && isset($_SESSION['first_name'])) {
            $message = "Account details";
            $is_authorized = 1;
        }
        else {
            $message = "Please login to access your account details.";
            $is_authorized = 0;
        }
    ?>
    <div class="row">
        <h1 align="center"><?php echo $message; ?></h1>
    </div>    
    <?php
        if(isset($_SESSION['is_logged_in']) && isset($_SESSION['first_name']))  {
            $fname = $_SESSION['first_name'];
        }
        if(isset($_SESSION['is_logged_in']) && isset($_SESSION['user_name']))  {
            $uname = $_SESSION['user_name'];
        }
        if(isset($_SESSION['is_logged_in']) && isset($_SESSION['last_name']))  {
            $lname = $_SESSION['last_name'];
        }
        if(isset($_SESSION['is_logged_in']) && isset($_SESSION['email']))  {
            $uemail = $_SESSION['email'];
        }
    ?>
    <?php
        if(isset($_SESSION['is_logged_in']) && isset($_SESSION['first_name'])) { ?>
    
    <div class="h-divider"></div>
    
    <div class="row">
        <br><br>
        <div class="col-md-12">
            <table>
                <tr>
                    <td>
                        <h4>User name:</h4>
                    </td>
                    <td>
                        <h4><?php echo $uname; ?></h4>
                    </td>                    
                </tr>
                <tr>
                    <td>
                        <h4>First name:</h4>
                    </td>
                    <td>
                        <h4><?php echo $fname; ?></h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>Last name:</h4>
                    </td>
                    <td>
                        <h4><?php echo $lname; ?></h4>
                    </td>                    
                </tr>
                <tr>
                    <td>
                        <h4>Email:</h4>
                    </td>
                    <td>
                        <h4><?php echo $uemail; ?></h4>
                    </td>
                </tr>
            </table>
        <br><br>    
        </div>      
    </div>
    <?php } ?>
    <div class="h-divider"></div>
</div>
