<?php

/*
 * authors - Richadavy Khok
 */
 
class MessagesModel
{
    const TABLE_NAME = 'messages';
    const LISTING_TABLE = 'listing';
    const USER_TABLE = 'user';
     
    function __construct($db)
    {
         try {
             $this->db = $db;
         } catch (PDOException $e) {
             exit('Database connection could not be established');
         }
    }
     
    public function contactMessage($message, $create_time, $subject, $listing_id)
    {
        session_start();
        if (isset($_SESSION['is_logged_in'])) {
            $from_user = $_SESSION['user_id'];
        }

        $to_user = self::getLandlordId($listing_id);
        $other_user_name = self::getUserName($to_user);
        $current_user_name = self::getUserName($from_user);       
        $conversation_id = $to_user . " " . $from_user;
        $address = self::getAddress($listing_id);
    
        $sql = "INSERT INTO " . self::TABLE_NAME . " (to_user, from_user, message, create_time, subject,
            listing_id, conversation_id, other_user_name, current_user_name, address)
         VALUES (:to_user, :from_user, :message, :create_time, :subject,
            :listing_id, :conversation_id, :other_user_name, :current_user_name, :address)";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':to_user' => $to_user,
            ':from_user' => $from_user,
            ':message' => $message, 
            ':create_time' => $create_time, 
            ':subject' => $subject,
            ':listing_id' => $listing_id, 
            ':conversation_id' => $conversation_id,
            ':other_user_name' => $other_user_name,
            ':current_user_name' => $current_user_name,
            ':address' => $address
            );
            
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters); 
        
    }

    public function deleteThread($message_id)
    {
        session_start();
        if (isset($_SESSION['is_logged_in'])) {
            $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE id = :messageId";
            $query = $this->db->prepare($sql);
            $parameters = array(':messageId' => $message_id);
            $query->execute($parameters);
           // echo '[PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
        }
    }

    public function getMessagesBySelf()
    {
        session_start();
        if (isset($_SESSION['is_logged_in'])) {
            $sql = "SELECT id, current_user_name, message, create_time, subject, listing_id, address FROM "
                 . self::TABLE_NAME . " WHERE to_user = :to_user_id";
            $query = $this->db->prepare($sql);
            $parameters = array(':to_user_id' => $_SESSION['user_id']);
            //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
            $query->execute($parameters);

            return $query->fetchAll();
        }
        else {
            return Array();
        }
    }
    
   /* public function getThreadByConversationId($to_user, $from_user)
    {
        $conversation_id = $to_user . " " . $from_user;
        $sql = "SELECT message FROM " . self::TABLE_NAME . "WHERE conversation_id = :conversation_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':conversation_id' => $conversation_id));
        
        return $query->fetchAll();
         
    }*/   
    
    public function getMessageById($message_id)
    {
        $sql = "SELECT id, to_user, from_user, message, create_time, 
            subject, listing_id, conversation_id, other_user_name, current_user_name FROM " .
            self::TABLE_NAME . " WHERE id = :messageId";
        $query = $this->db->prepare($sql);
        $parameters = array(':messageId' => $message_id);
        $query->execute($parameters);
        return $query->fetch();
        echo '[PDO DEBUG]: ' . Helper::debugPDO($sql, $parameters); exit();
    }
   

    public function addReply($to_user, $message, $create_time, $subject, $listing_id)
   // public function addReply($message, $create_time)
    {
        session_start();
        if (isset($_SESSION['is_logged_in'])) {
            $from_user = $_SESSION['user_id'];
        }
        
       // $to_user = 14;
       // $listing_id = 35;
       // $subject = NULL;
        $re_subject = "RE: " . $subject;
        $conversation_id = $to_user . " " . $from_user;
        $other_user_name = self::getUserName($to_user);
        $current_user_name = self::getUserName($from_user);
        $address = self::getAddress($listing_id);
        
        $sql = "INSERT INTO " . self::TABLE_NAME . " (to_user, from_user, message, create_time, 
            subject, listing_id, conversation_id, other_user_name, current_user_name, address)
         VALUES (:to_user, :from_user, :message, :create_time, :subject,
            :listing_id, :conversation_id, :other_user_name, :current_user_name, :address)";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':to_user' => $to_user,
            ':from_user' => $from_user,
            ':message' => $message, 
            ':create_time' => $create_time, 
            ':subject' => $re_subject,
            ':listing_id' => $listing_id, 
            ':conversation_id' => $conversation_id,
            ':other_user_name' => $other_user_name,
            ':current_user_name' => $current_user_name,
            ':address' => $address
            );
            
        // useful for debugging: you can see the SQL behind above construction by using:
       // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters); 
    }
 
    //finds the id so that it can find the name in getLandlordName
    private function getLandlordId($listing_id)
    {
        $sql = "SELECT landlord_id FROM " . self::LISTING_TABLE . " WHERE id = :listingId";
        $query = $this->db->prepare($sql);
        $query->execute(array(':listingId' => $listing_id));
        $landlord_id = $query->fetchColumn();

        return $landlord_id;
    }

    private function getAddress($listing_id)
    {
        $sql = "SELECT street FROM " . self::LISTING_TABLE . " WHERE id = :listingId";
        $query = $this->db->prepare($sql);
        $query->execute(array(':listingId' => $listing_id));
        $address = $query->fetchColumn();
        
        return $address;
    }
    
    private function getUserName($user_id)
    {
        $sql = "SELECT first_name FROM " . self::USER_TABLE . " WHERE id = :userId";
        $query = $this->db->prepare($sql);
        $query->execute(array(':userId' => $user_id));
        $user_name = $query->fetchColumn();

        return $user_name;   
    }
}
