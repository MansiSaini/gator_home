<?php

/* 
 * authors - Rupal K
 */

class ThumbnailModel
{
    const TABLE_NAME = 'thumbnail';
    const MEDIA_TABLE_NAME = 'media';
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

    /**
     * @param media_id - The Media Id of the image associated with the thumbnail.
     * @param file_path - The file path of the uploaded thumbnail.
     * @param width - The width of the thumbnail.    
     */
    public function addThumbnail($media_id, $file_path, $width)
    {
        $sql = "INSERT INTO ". self::TABLE_NAME . " (media_id, file_path, width)
            VALUES (:media_id, :file_path, :width)";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':media_id' => $media_id,
            ':file_path' => $file_path,
            ':width' => $width,
        );
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);          
    }

    /**
     * @param media_id - The Media Id of the image associated with the thumbnail.  
     */
    public function getThumbnailPath($media_id)
    {
        $sql = "SELECT file_path FROM " . self::TABLE_NAME . " WHERE media_id=:media_id AND width=200";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':media_id' => $media_id,
        );
        $query->execute($parameters);

        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        return $query->fetch();
    }

    /**
     * @param media_id_list -  An array of Media Ids
     */
    public function getThumbnailPaths($media_id_list)
    {
        $comma_list = "''";
        if ($media_id_list) {
            $comma_list = implode(', ', $media_id_list);
        }
        $sql = "SELECT media_id, file_path FROM " . self::TABLE_NAME . " WHERE media_id IN (" . $comma_list . ")" ;
        $query = $this->db->prepare($sql);
        
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, []);  exit();
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param 
     */ 
    public function getAllThumbnailMediaInfo()
    {
        $sql = "SELECT " . self::MEDIA_TABLE_NAME . ".listing_id as listing_id," .
        self::MEDIA_TABLE_NAME . ".id as media_id," . 
        self::MEDIA_TABLE_NAME . ".file_path as media_file," .
        self::TABLE_NAME . ".id  as thumbnail_id," . 
        self::TABLE_NAME . ".file_path as thumbnail_path from " .
        self::MEDIA_TABLE_NAME . "," . self::TABLE_NAME . " where " .
        self::MEDIA_TABLE_NAME . ".id = " . self::TABLE_NAME . ".media_id";

        $query = $this->db->prepare($sql);
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, []);  exit();
        $query->execute();
        return $query->fetchAll();      
    }
}

