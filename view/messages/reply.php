<div class="container">

    <div class="box" align="center">
        <form action="<?php echo URL; ?>messages/sendReply" method="post">
        <table>
            <tr>
            <td>Name: <?php if (isset($message->id)) echo htmlspecialchars($message->current_user_name, ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <tr>
            <td>Subject: <?php if (isset($message->id)) echo htmlspecialchars($message->subject, ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <tr>
            <td><?php echo htmlspecialchars($message->current_user_name, ENT_QUOTES, 'UTF-8'); ?>'s message: </td>  
            <td><?php if (isset($message->id)) echo htmlspecialchars($message->message, ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <tr><td>Reply Here:</td>
            <br>
            <td><textarea type="text" name="message" value="" rows=10 cols=40></textarea></td>
            </tr>
            <input type="hidden" name="to_user" value="<?php if(isset($message->id)) echo htmlspecialchars($message->from_user, ENT_QUOTES, 'UTF-8'); ?>" />
            <input type="hidden" name="subject" value="<?php if(isset($message->id)) echo htmlspecialchars($message->subject, ENT_QUOTES, 'UTF-8'); ?>" />
            <input type="hidden" name="listing_id" value="<?php if(isset($message->id)) echo htmlspecialchars($message->listing_id, ENT_QUOTES, 'UTF-8'); ?>" />
        </table>
        <a class="btn btn-success" style="background-color:#33cccc;" href="<?php echo URL . 'messages/index/' . htmlspecialchars($message->id, ENT_QUOTES, 'UTF-8'); ?>">Go Back</a>
        <button class="btn btn-primary" style="background-color:#33cccc;" href="<?php echo URL . 'messages/index/' . htmlspecialchars($message->id, ENT_QUOTES, 'UTF-8'); ?>" type="submit" name="submit_message_reply" value="Send a Reply">Send Reply</button>
        </form>
    </div>
  
</div>
