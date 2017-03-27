<div class="container">

  <div class="table-responsive">
  <table class="table">
  <h2 align="center">View your messages</h2>
    <thead>
      <tr>
        <th>#</th>
        <th>Apartment Address</th>
        <th>Name</th>
        <th>Subject</th>
        <th>View Message</th>
        <th>Reply</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($messages as $message) { ?>
      <tr>
        <td><?php if (isset($message->id)) echo htmlspecialchars($message->id, ENT_QUOTES, 'UTF-8'); ?></td> 
        <td><?php if (isset($message->id)) echo htmlspecialchars($message->address, ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php if (isset($message->id)) echo htmlspecialchars($message->current_user_name, ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php if (isset($message->id)) echo htmlspecialchars($message->subject, ENT_QUOTES, 'UTF-8'); ?></td>      
        
        
        <td><button type="button" style="background-color:#33cccc" class="btn btn-success" data-toggle="modal" data-target="#myModal<?php echo htmlspecialchars($message->id, ENT_QUOTES, 'UTF-8'); ?>">View Message</button></td>
        <div class="modal fade" id="myModal<?php echo htmlspecialchars($message->id, ENT_QUOTES, 'UTF-8'); ?>" role="dialog">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php if(isset($message->id)) echo htmlspecialchars($message->current_user_name, ENT_QUOTES, 'UTF-8'); ?>'s Message </h4>
            </div>
            <div class="modal-body">      
            <div class="form-group">
                <h2><?php if (isset($message->id)) echo htmlspecialchars($message->message, ENT_QUOTES, 'UTF-8'); ?></h2>
            <br>
            </div>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
      </div>
    </div>
  </div> 
        <td><a class="btn btn-success" style="background-color:#33cccc;" href="<?php echo URL . 'messages/reply/' . htmlspecialchars($message->id, ENT_QUOTES, 'UTF-8'); ?>">Reply</a></td>
        <td><a class="btn btn-success" style="background-color:#33cccc;" href="<?php echo URL . 'messages/deleteMessage/' . htmlspecialchars($message->id, ENT_QUOTES, 'UTF-8'); ?>">Delete</a></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
  </div>
</div>

