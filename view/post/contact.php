<div class="container">
    <?php
        $loginUrl = URL . "login";
        if(isset($_SESSION['is_logged_in']) && isset($_SESSION['first_name'])) {
            $message = "Contact the landlord";
            $is_authorized = 1;
        }
        else {
            $message = "Please <a href=" . $loginUrl . ">login</a> to Post or view your listings.";
            $is_authorized = 0;
        }
    ?>

    <h3 align="center"><?php echo $message; ?></h3>

    <?php
        if(isset($_SESSION['is_logged_in']) && isset($_SESSION['first_name'])) { ?>

    <!-- add song form -->
    <div class="box" align="center">
        <form action="<?php echo URL; ?>post/sendFirstContactMessage" method="POST">
        <table>
            <tr><td>Address:</td>
            <td> <?php if (isset($listing->id)) echo htmlspecialchars($listing->street, ENT_QUOTES, 'UTF-8'); ?>, <?php if (isset($listing->id)) echo htmlspecialchars($listing->city, ENT_QUOTES, 'UTF-8'); ?>, <?php if (isset($listing->id)) echo htmlspecialchars($listing->state, ENT_QUOTES, 'UTF-8'); ?> <?php if (isset($listing->id)) echo htmlspecialchars($listing->zipcode, ENT_QUOTES, 'UTF-8'); ?></td> 
            </tr>
            <tr><td>Subject:</td>
            <td><input type="text" name="subject" value="" required /></td>
            </tr>
            <!-- Print the cross street only if it is present -->
            <tr><td>Message:</td>
            <td><textarea type="text" name="message" value="" rows=10 cols=40></textarea></td>
            </tr>
        </table>
            <input type="hidden" name="listing_id" value="<?php echo htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>" />
            <input type="submit" name="submit_contact_landlord" value="Send" />
        </form>
    </div>
    <?php }?>
</div>
