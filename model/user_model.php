<?php

/* 
 * authors - Rupal K
 */

class UserModel
{
    const TABLE_NAME = 'user';
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function addUser($firstName, $lastName, $userName, $password, $email, $isAdmin)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (first_name, last_name, user_name, password, email, is_admin)
         VALUES (:firstName, :lastName, :userName, :password, :email, :isAdmin)";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':firstName' => $firstName,
            ':lastName' => $lastName,   
            ':userName' => $userName,
            ':password' => $hash,
            ':email' => $email,
            ':isAdmin' => $isAdmin
        );

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);        
    }
    /**
     * Get all users from database
     */
    public function getAllUsers()
    {
        $sql = "SELECT id, first_name, last_name, user_name, email, is_admin FROM user";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    /**
     * Get a user from database
     */
    public function getUser($username, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT id, first_name, last_name, user_name, password, email, is_admin FROM user WHERE user_name = :username";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':username' => $username,
        );
        // useful for debugging: you can see the SQL behind above construction by using:
        //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        $results  = $query->fetch();

        if ($results && password_verify($password, $results->password)) {
            return $results;
        }
        else {
            return Array();
        }
    }

    /*
     * Gets the user based on matching email ID or username
     * Note: Used for validating registration to prevent users
     * from using a username or email address that is already in use.
     */
    public function getExistingUser($email, $username) {
        $sql = "SELECT id, first_name, last_name, user_name, email, is_admin FROM user WHERE user_name = :username OR email = :email";

        $query = $this->db->prepare($sql);
        $parameters = array(
            ':username' => $username,
            ':email' => $email
        );
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        //fetch() is the PDO method that get exactly one result
        $results  = $query->fetch();
        return $results;
    }

}
