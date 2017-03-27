<?php

/**
 * Class Messages
 *
 */
class Messages extends Controller
{
    /**
     * PAGE: message
     */
    public function index()
    {
        $messages = $this->messagesModel->getMessagesBySelf();
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/messages/message.php';
        require APP . 'view/_templates/footer.php';
    }

    public function reply($message_id)
    {
        if(isset($message_id))
         {
            $message = $this->messagesModel->getMessageById($message_id);
        
            //redirects to an edit page
            //after edit is made, update function makes the changes
            require APP . 'view/_templates/header.php';
            require APP . 'view/messages/reply.php';
            require APP . 'view/_templates/footer.php';
        }
        else
        {
            //header('location: ' . URL . '______'); ______ is where the error page is if the listing is not found
            echo "Error cannot edit";
        }
    }
    
    public function sendReply()
    {
        if(isset($_POST["submit_message_reply"])) {
            $create_time = date('Y-m-d H:i:s');
            $this->messagesModel->addReply($_POST['to_user'], $_POST['message'], $create_time, $_POST['subject'], $_POST['listing_id']);
           // $this->messageModel->addReply($_POST['message'], $create_time);
        } else {
           echo "reply not sent";
        }

       // header('location: ' . URL . '../messages/message/');
        header('location: ' . URL . 'messages/index');
    }

    public function deleteMessage($message_id)
    {  
        if(isset($message_id))
        {
            $this->messagesModel->deleteThread($message_id);
        }
       
        header('location: ' . URL . 'messages/index');
    }
}
