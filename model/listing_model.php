<?php

/* 
 * authors - Rupal K, Richadavy K, Jeffery
 */

class ListingModel
{
    const TABLE_NAME = 'listing';
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

    /*
     * Add a new listing
     */
    public function addListing($price, $street, $apt, $crossStreet, $city,
            $state, $zipcode, $type, $isFurnished, $isAccessible, $isSmoke,
            $hasParking, $petsAllowed, $campusDistance, $bed, $bath, $size,
            $description, $landlord_id, $latitude, $longitude)
    {
        $utilities = "";
        if ($isFurnished) {
            $utilities .= "furnished ";
        }

        if ($isSmoke) {
            $utilities .= "smoking ";
        }

        if ($hasParking) {
            $utilities .= "parking ";
        }

        if ($isAccessible) {
            $utilities .= "accessible ";
        }

        if ($petsAllowed) {
            $utilities .= "pets ";
        }
        $sql = "INSERT INTO " . self::TABLE_NAME . " (price, street, apt, cross_street, city,
            state, zipcode, type, is_furnished, is_accessible, is_smoke,
            has_parking, campus_distance,
            size, description, utilities, landlord_id, latitude, longitude,
            bed, bath, pets_allowed)
            VALUES (:price, :street, :apt, :cross_street, :city,
            :state, :zipcode, :type, :is_furnished, :is_accessible, :is_smoke,
            :has_parking, :campus_distance,
            :size, :description, :utilities, :landlord_id, :latitude, :longitude,
            :bed, :bath, :pets_allowed)";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':price' => $price,
            ':street' => $street,
            ':apt' => $apt, 
            ':cross_street' => $crossStreet, 
            ':city' => $city,
            ':state' => $state, 
            ':zipcode' => $zipcode,
            ':type' => $type, 
            ':is_furnished' => $isFurnished, 
            ':is_accessible' => $isAccessible, 
            ':is_smoke' => $isSmoke,
            ':has_parking' => $hasParking, 
            ':campus_distance' => $campusDistance, 
            ':size' => $size, 
            ':description' => $description,
            ':utilities' => $utilities,
            ':landlord_id' => $landlord_id,
            ':latitude' => $latitude,
            ':longitude' => $longitude,
            ':bed' => $bed,
            ':bath' => $bath,
            ':pets_allowed' => $petsAllowed
        );

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
        return $this->db->lastInsertId();
    }
    /**
     * Get all listings from database
     */
    public function getAllListings()
    {
        $sql = "SELECT id, price, street, apt, cross_street, city,
            state, zipcode, type, is_furnished, is_accessible, is_smoke,
            has_parking, campus_distance, create_time, last_update_time,
            size, description, utilities, latitude, longitude,
	    bed, bath, pets_allowed FROM " . self::TABLE_NAME;
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    /**
     * Get all listings from database by ID
     */
    public function getListingById($listing_id)
    {

        $sql = "SELECT id, price, street, apt, cross_street, city,
            state, zipcode, type, is_furnished, is_accessible, is_smoke,
            has_parking, campus_distance, create_time, last_update_time,
            size, description, utilities, latitude, longitude,
	    bed, bath, pets_allowed FROM " .
            self::TABLE_NAME . " WHERE id = :listingId LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':listingId' => $listing_id);
        $query->execute($parameters);
        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetch();
    }

    /**
     * Get all listings by Self
     */
    public function getListingsBySelf()
    {
        session_start();
        if (isset($_SESSION['is_logged_in'])) {
            $sql = "SELECT id, price, street, apt, cross_street, city,
                state, zipcode, type, is_furnished, is_accessible, is_smoke,
                has_parking, campus_distance, create_time, last_update_time,
                size, description, utilities, latitude, longitude,
		bed, bath, pets_allowed FROM " .
                 self::TABLE_NAME . " WHERE landlord_id=:user_id";
            $query = $this->db->prepare($sql);
            $parameters = array(':user_id' => $_SESSION['user_id']);
            //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
            $query->execute($parameters);

            return $query->fetchAll();
        }
        else {
            return Array();
        }
    }

    /**
     * Get a listing from database by search
     * Searching by each term, can also search by oprators >, <, ==
     */
    public function getListingsFromSearch($searchString)
    {
        // remove all semicolons from the search string
        $searchString = trim(str_replace(';', ' ', $searchString));
        if (empty($searchString)) {
            $searchString = '.';
        }
        // separate the search string based on separators
        $parts = preg_split('/\s+/', $searchString);

        $modifiedSearchString = join('|', $parts);
        $sql = "SELECT id, price, street, apt, cross_street, city,
            state, zipcode, type, is_furnished, is_accessible, is_smoke,
            has_parking, campus_distance, create_time, last_update_time,
            size, description, utilities, latitude, longitude,
	    bed, bath, pets_allowed FROM " . self::TABLE_NAME . " WHERE 
            CONCAT_WS(zipcode, apt, cross_street, street, city, state, description, utilities) REGEXP :searchString";

        if (preg_match('/<|>|=|!/', $searchString)) {
            $operator = '';
            if ($matches = preg_grep('/<=/', $parts)) {
                $searchOperator = '/<=/';
                $operator = '<=';
            }
            else if ($matches = preg_grep('/>=/', $parts)) {
                $searchOperator = '/>=/';
                $operator = '>=';
            }
            else if ($matches = preg_grep('/>/', $parts)) {
                $searchOperator = '/>/';
                $operator = '>';
            }
            else if ($matches = preg_grep('/</', $parts)) {
                $searchOperator = '/</';
                $operator = '<';
            }
            else if ($matches = preg_grep('/==/', $parts)) {
                $searchOperator = '/==/';
                $operator = '=';
            }
            else if ($matches = preg_grep('/=/', $parts)) {
                $searchOperator = '/=/';
                $operator = '=';
            }
            else if ($matches = preg_grep('/!=/', $parts)) {
                $searchOperator = '/!=/';
                $operator = '<>';
            }

            if ($operator != '') {
                foreach ($matches as $match) {
                    $index = preg_match($searchOperator, $match);
                    $parts[$index-1] = str_replace($operator, '', $parts[$index-1]);
                    break; // only caters to the first match
                }
                // filter numeric parts.
                $parts = array_filter($parts, 'is_numeric');
                $conditionString = " OR CONCAT(price, campus_distance, size) " . $operator . join(' ', $parts);
                $sql .= $conditionString;
            }
        }
        $query = $this->db->prepare($sql);
        $parameters = array(':searchString' => $modifiedSearchString);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        $records =  $query->fetchAll();

        return $records;
    }

    /**
     * Delete a listing.
     */
	public function deleteListing($listing_id)
	{
		$sql = "DELETE FROM " . self::TABLE_NAME . " WHERE id = :listingId";
		//db refers to the db name set a(t beginning of class
		$query = $this->db->prepare($sql);
		$parameters = array(':listingId' => $listing_id);
	
		//useful for debugging: you can see the SQL behind above construction by using:
		//echo '[PDO DEBUG]: ' . Helper::debugPDO($sql, $parameters); exit();
	
		$query->execute($parameters);
		
	}
	
    /**
     * Update a listing.
     */
	public function updateListing($price, $street, $apt, $crossStreet, $city,
								  $state, $zipcode, $type, $isFurnished, $isAccessible, $isSmoke,
								  $hasParking, $campusDistance, $size, $description, $listing_id, $bed, $bath, $petsAllowed, $latitude, $longitude)
	{
		$utilities = "";
		if ($isFurnished)
			$utilities .= "furnished ";
		if ($isSmoke)
			$utilities .= "smoking ";
		if ($hasParking)
			$utilities .= "parking ";
		if ($isAccessible)
			$utilities .= "accessible";
		if ($petsAllowed)
			$utilities .= "pets";

		$sql = "UPDATE " . self::TABLE_NAME . " SET 
												price = :price, 
												street = :street, 
												apt = :apt, 
												cross_street = :cross_street, 
												city = :city, 
												state = :state, 
												zipcode = :zipcode, 
												type = :type, 
												bed = :bed,
												bath = :bath,
												is_furnished = :is_furnished, 
												is_accessible = :is_accessible, 
												is_smoke = :is_smoke, 
												has_parking = :has_parking, 
												campus_distance = :campus_distance, 
												pets_allowed = :pets_allowed,
												size = :size, 
												description = :description,
												utilities = :utilities,
                                                latitude = :latitude,
                                                longitude = :longitude 		
												WHERE id = :listing_id";
		$query = $this->db->prepare($sql);
		$parameters = array(':price' => $price, 
							':street' => $street, 
							':apt' => $apt,
							':cross_street' => $crossStreet, 
							':city' => $city, 
							':state' => $state, 
							':zipcode' => $zipcode, 
							':type' => $type,
							':bed' => $bed,
							':bath' => $bath,
							':pets_allowed' => $petsAllowed, 
							':is_furnished' => $isFurnished, 
							':is_accessible' => $isAccessible, 
							':is_smoke' => $isSmoke, 
							':has_parking' => $hasParking, 
							':campus_distance' => $campusDistance, 
							':size' => $size, 
							':description' => $description,
							':utilities' => $utilities,
                            ':latitude' => $latitude,
                            ':longitude' => $longitude,
							':listing_id' => $listing_id);
	
		//useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper:: debugPDO($sql, $parameters); exit();
	
		$query->execute($parameters);

	}

    /**
     * Get listings by filters (includes sort)
     */
    public function getListingsByFilters($filters) {
        $sql = "SELECT id, price, street, apt, cross_street, city,
                    state, zipcode, type, is_furnished, is_accessible, is_smoke,
                    has_parking, campus_distance, create_time, last_update_time, latitude, longitude,
                    size, description, bed, bath, pets_allowed, utilities FROM " . self::TABLE_NAME;

        $clauses = Array();
        // Numeric filters
        if (array_key_exists('min_price', $filters)) {
            array_push($clauses, " price >= " . $filters['min_price']);
        }
        if (array_key_exists('max_price', $filters)) {
            array_push($clauses, " price <= " . $filters['max_price']);
        }
        if (array_key_exists('min_size', $filters)) {
            array_push($clauses, " size <= " . $filters['max_size']);
        }
        if (array_key_exists('max_size', $filters)) {
            array_push($clauses, " size >= " . $filters['min_size']);
        }
        if (array_key_exists('max_distance', $filters)) {
            array_push($clauses, " campus_distance <= " . $filters['max_distance']);
        }
        if (array_key_exists('min_distance', $filters)) {
            array_push($clauses, " campus_distance >= " . $filters['min_distance']);
        }

        // Boolean filters
        if (array_key_exists('is_furnished', $filters)) {
            array_push($clauses, " is_furnished = " . $filters['is_furnished']);
        }
        if (array_key_exists('is_smoke', $filters)) {
            array_push($clauses, " is_smoke = " . $filters['is_smoke']);
        }
        if (array_key_exists('is_accessible', $filters)) {
            array_push($clauses, " is_accessible = " . $filters['is_accessible']);
        }
        if (array_key_exists('has_parking', $filters)) {
            array_push($clauses, " has_parking = " . $filters['has_parking']);
        }
	if (array_key_exists('pets_allowed', $filters)) {
	    array_push($clauses, "pets_allowed = " . $filters['pets_allowed']);
	}
        // Textual filters
        $parameters = array();
        if (array_key_exists('street', $filters)) {
            array_push($clauses, " CONCAT(street, cross_street) REGEXP :street");
            $parameters[":street"] = trim($filters['street']);
        }
        if (array_key_exists('city', $filters)) {
            array_push($clauses, " city REGEXP :city");
            $parameters[":city"] = trim($filters['city']);
        }
        if (array_key_exists('state', $filters)) {
            array_push($clauses, " state REGEXP :state");
            $parameters[":state"] = trim($filters['state']);
        }
        if (array_key_exists('zipcode', $filters)) {
            array_push($clauses, " zipcode = :zipcode");
            $parameters[":zipcode"] = trim($filters['zipcode']);
        }

        if (count($clauses) > 0)
            $sql .= " WHERE ";

        $clausesString = implode(" AND ", $clauses);
        $sql .= $clausesString;

        if (array_key_exists('price_low_to_high', $filters)) {
            $sql .= " ORDER BY price ";
        }
        else if (array_key_exists('price_high_to_low', $filters)) {
            $sql .= " ORDER BY price DESC";
        }
        else if (array_key_exists('most_recent', $filters)) {
            $sql .= " ORDER BY create_time DESC";
        }

        $query = $this->db->prepare($sql);
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
        $results = $query->fetchAll();

        if (array_key_exists('search', $filters)) {
            $queryResults = $this->getListingsFromSearch($filters['search']);
            $results = array_intersect_key($results, $queryResults);
        }

        return $results;
        
    }
}
