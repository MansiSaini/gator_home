<?php

/* 
 * authors - Rupal K
 */

class MediaModel
{
    const TABLE_NAME = 'media';
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

    public function addMedia($listing_id, $filename, $file_type)
    {
        $sql = "INSERT INTO ". self::TABLE_NAME . " (listing_id, file_type, file_path)
            VALUES (:listing_id, :file_type, :filename)";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':listing_id' => $listing_id,
            ':file_type' => $file_type,
            ':filename' => $filename
        );
        // useful for debugging: you can see the SQL behind above construction by using:
        //  echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
        return $this->db->lastInsertId();
    }

    public function getMediaIds($listing_id)
    {
        $sql = "SELECT id FROM " . self::TABLE_NAME . " WHERE listing_id=:listing_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':listing_id' => $listing_id,
        );
        $query->execute($parameters);

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    public function getMediaPaths($listing_id)
    {
        $sql = "SELECT file_type,file_path FROM " . self::TABLE_NAME . " WHERE listing_id=:listing_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':listing_id' => $listing_id,
        );
        $query->execute($parameters);

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        return $query->fetchAll();
    }
}

