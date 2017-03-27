<?php


/**
 * Class Post
 * Author - Rupal K, Richadavy K
 */
class Post extends Controller
{
    /**
     * PAGE: index
     */
    public function index()
    {
        $listings = $this->listingModel->getListingsBySelf();
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/post/index.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * PAGE: Create new listing
     */
    public function create()
    {

        require APP . 'view/_templates/header.php';
        if (isset($_SESSION['is_logged_in'])) {
            require APP . 'view/post/new.php';
        }
        else {
            require APP . 'view/post/index.php';
        }
        require APP . 'view/_templates/footer.php';               
    }

    /**
     * Uploads a new media item associated with the given listing_id
     */
    private function uploadMedia($listing_id) {
        // source : http://stackoverflow.com/questions/37020953/php-multiple-uploads-keeping-files-names
        $j = 0; 
        for ($i = 0; $i < count($_FILES['files']['name']); $i++) { //loop to get individual element from the array
            $target_path = UPLOAD_DIR;
            $validextensions = array("jpeg", "jpg", "png", "gif"); //Extensions which are allowed
            $ext = explode('.', basename($_FILES['files']['name'][$i])); //explode file name from dot(.) 
            $file_extension = end($ext); //store extensions in the variable
            $file_type = $_FILES['files']['type'][$i];
            $new_file_name = md5(uniqid()).".".$ext[count($ext) - 1]; //set the target path with a new name of image
            $target_path = $target_path . $new_file_name;
            $j = $j + 1; //increment the number of uploaded images according to the files in array       

            if (($_FILES["files"]["size"][$i] < 10000000)
                && in_array($file_extension, $validextensions)) {
                if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $target_path)) {
                    $latest_media_id = $this->mediaModel->addMedia($listing_id, UPLOAD_PATH . $new_file_name, $file_type);
                    $this->createAndUploadThumbnail($target_path, $latest_media_id, $ext[count($ext) - 1], 300);
                    $message =  $j.
                    ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
                } else { //if file was not moved.
                    $message =  $j.
                    ').<span id="error">please try again!.</span><br/><br/>';
                }
            } else { //if file size and file type was incorrect.
                $message =  $j.
                ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
            }
        }
    }

    /**
     * Creates and uploads a thumbnail for the given media_id
     */
    private function createAndUploadThumbnail($target_path, $media_id, $file_ext, $thumb_width) {
        $thumb_path = THUMBNAIL_DIR;
        $filename = md5(uniqid()) . "." . $file_ext; 
        $thumbnail = $thumb_path . $filename;
        $upload_image = $target_path;
        list($width, $height) = getimagesize($upload_image);
        $thumb_height = ($thumb_width/$width) * $height;
        $thumb_create = imagecreatetruecolor($thumb_width, $thumb_height);
        $success = false;
        switch($file_ext){
            case 'jpg':
                $source = imagecreatefromjpeg($upload_image);
                break;
            case 'jpeg':
                $source = imagecreatefromjpeg($upload_image);
                break;
            case 'png':
                $source = imagecreatefrompng($upload_image);
                break;
            case 'gif':
                $source = imagecreatefromgif($upload_image);
                break;
            default:
                $source = imagecreatefromjpeg($upload_image);
        }
        imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
        switch($file_ext){
            case 'jpg' || 'jpeg':
                imagejpeg($thumb_create, $thumbnail, 100); // Create thumbnail of best quality (100)
                $success = true;
                break;
            case 'png':
                imagepng($thumb_create, $thumbnail, 100);
                $success = true;
                break;
            case 'gif':
                imagegif($thumb_create, $thumbnail, 100);
                $success = true;
                break;
            default:
                imagejpeg($thumb_create, $thumbnail, 100);
                $success = true;
        }
        // Insert record in the database
        if ($success) {
            $this->thumbnailModel->addThumbnail($media_id, UPLOAD_PATH . 'thumbnails/' . $filename, $thumb_width);
        }
    }

    /*
    * Returns the latitude and longitude coordinates given the address.
    */
    private function getLatLong($address) {
        $url = MAPS_QUERY_URL . '?address=' . urlencode($address) . '&key=' . API_KEY;
         // Make the HTTP request
        $data = @file_get_contents($url);
        // Parse the json response
        $jsondata = json_decode($data,true);

        // If the json data is invalid, return empty array
        $latLong = array();
        if ($jsondata["status"] == "OK") {
            $latLong = array(
                'lat' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                'lng' => $jsondata["results"][0]["geometry"]["location"]["lng"],
            );
        }
        return $latLong;
    }

    /*
    * Returns the distance from SFSU given the coordinates.
    */
    private function getDistance($latLong) {
        $source = SFSU_LAT . ',' . SFSU_LONG;
        $destination = array_key_exists('lat', $latLong) ? $latLong['lat'] . ',' . $latLong['lng'] : NULL;
        $url = MAPS_DISTANCE_URL .
            '?units=imperial' .
            '&origins=' .
            urlencode($source) .
            '&destinations=' .
            urlencode($destination) .
            '&key=' . API_KEY;

         // Make the HTTP request
        $data = @file_get_contents($url);
        // Parse the json response
        $jsondata = json_decode($data, true);

        // If the json data is invalid, return empty array
        $distance = 0;
        if ($jsondata["status"] == "OK") {
            $distance = $jsondata["rows"][0]["elements"][0]["distance"]["text"];
            $distance = str_replace("mi", "", $distance);
            $distance = trim($distance);
        }
        return $distance;
    }

    /**
     * Adds a new listing
     */
    public function add()
    {
        if (isset($_POST["submit_add_post"])) {

            $is_furnished = 0;
            $is_accessible = 0;
            $is_smoke = 0;
            $has_parking = 0;
            $pets_allowed = 0;
            if(isset($_POST['is_furnished'])){
                $is_furnished = 1;
            }
            if(isset($_POST['is_accessible'])){
                $is_accessible = 1;
            }
            if(isset($_POST['is_smoke'])){
                $is_smoke = 1;
            }
            if(isset($_POST['has_parking'])){
                $has_parking = 1;
            }
            if(isset($_POST['pets_allowed'])){
                $pets_allowed = 1;
            }
            session_start();
            if(isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
            }

            // find the latitude and longitude of the given address.
            if (isset($_POST['apt'])) {
                $address = $_POST['apt'] . 
                ' ' . $_POST['street'] .
                ' ' . $_POST['city'] .
                ' ' . $_POST['state'] .
                ' ' . $_POST['zipcode'];
            } else {
                $address = $_POST['street'] . 
                ' & ' . $_POST['cross_street'] .
                 $_POST['city'] .
                 ' ' . $_POST['state'] .
                 ' ' . $_POST['zipcode'];
            }
            
            $latLong = $this->getLatLong($address);

            $distance = $this->getDistance($latLong);

            // do addSong() in model/model.php
            $id = $this->listingModel->addListing(
                $_POST["price"],
                $_POST["street"],
                $_POST["apt"],
                $_POST["cross_street"],
                $_POST["city"],
                $_POST["state"],
                $_POST["zipcode"],
                $_POST["type"],
                $is_furnished,
                $is_accessible,
                $is_smoke,
                $has_parking,
                $pets_allowed,
                $distance,
                $_POST["bed"],
                $_POST["bath"],
                $_POST["size"],
                $_POST["description"],
                $user_id,
                array_key_exists('lat', $latLong) ? $latLong['lat'] : NULL,
                array_key_exists('lng', $latLong) ? $latLong['lng'] : NULL
            );

            $this->uploadMedia($id);

            // where to go after user has been registered
            header('location: ' . URL . 'post/index');
        } 
        else {
            header('location: ' . URL . 'login/index');
        }        
    }

    /**
     * PAGE: Contact page
     */
    public function contact($listing_id)
    {
       // if (isset($_SESSION['is_logged_in'])) {
           if (isset($listing_id)) {
                $listing = $this->listingModel->getListingById($listing_id);
                
                require APP . 'view/_templates/header.php';
                require APP . 'view/post/contact.php';
                require APP . 'view/_templates/footer.php';

           } else {
                echo "Error cannot getListing for contact";
           } 
       // } else {
       //    header('location: ' . URL . 'post/index');
       // }       
    }
    
     public function sendFirstContactMessage()
     {
        if (isset($_POST["submit_contact_landlord"]))
        {
            $create_time = date('Y-m-d H:i:s');
            $this->messagesModel->contactMessage($_POST['message'], $create_time, $_POST['subject'], $_POST['listing_id']);
           
        }         
        header('location: ' . URL . 'post/index');
     }

    /**
     * PAGE: Delete a listing based on ID
     */
    public function delete($listing_id)
    {
        if(isset($listing_id))
        {
            //model refers to the php model name
            $this->listingModel->deleteListing($listing_id);
        } 
        else 
        {
            echo "Error cannot delete";
        }
        
    
        //where to relocate after delete (must have site)
        header('location: ' . URL . 'post/index'); //________ is where to put view php
    }

    /**
     * PAGE: Display page for editing a listing
     */
    public function edit($listing_id)
    {
        if(isset($listing_id))
        {
            $listing = $this->listingModel->getListingById($listing_id);
        
            //redirects to an edit page
            //after edit is made, update function makes the changes
            require APP . 'view/_templates/header.php';
            require APP . 'view/post/edit.php';
            require APP . 'view/_templates/footer.php';
        }
        else
        {
            //header('location: ' . URL . '______'); ______ is where the error page is if the listing is not found
            echo "Error cannot edit";
        }
    }

    /**
     * PAGE: Update an existing listing
     */
    public function update()
    {
        // if we have POST data to create a new listing
        if(isset($_POST["submit_update_listing"]))
        {
            $is_furnished = 0;
            $is_accessible = 0;
            $has_parking = 0;
            $pets_allowed = 0;
            $is_smoke = 0;

            if(isset($_POST['is_furnished']))
                $is_furnished = 1;
            if(isset($_POST['is_accessible']))
                $is_accessible = 1;
            if(isset($_POST['is_smoke']))
                $is_smoke = 1;
            if(isset($_POST['has_parking']))
                $has_parking = 1;
            if(isset($_POST['pets_allowed']))
                $pets_allowed = 1; 
            //do updateListingDB() from model/model.php

            // find the latitude and longitude of the given address.
            if (isset($_POST['apt'])) {
                $address = $_POST['apt'] . 
                ' ' . $_POST['street'] .
                ' ' . $_POST['city'] .
                ' ' . $_POST['state'] .
                ' ' . $_POST['zipcode'];
            } else {
                $address = $_POST['street'] . 
                ' & ' . $_POST['cross_street'] .
                 $_POST['city'] .
                 ' ' . $_POST['state'] .
                 ' ' . $_POST['zipcode'];
            }
            
            $latLong = $this->getLatLong($address);

            $distance = $this->getDistance($latLong);
            $this->listingModel->updateListing($_POST['price'], $_POST['street'], $_POST['apt'],
                $_POST['cross_street'], $_POST['city'], $_POST['state'], $_POST['zipcode'],
                $_POST['type'], $is_furnished, $is_accessible, $is_smoke, $has_parking,
                -1, $_POST['size'], $_POST['description'], $_POST['listing_id'], $_POST['bed'],
                $_POST['bath'], $pets_allowed, array_key_exists('lat', $latLong) ? $latLong['lat'] : NULL,
                array_key_exists('lng', $latLong) ? $latLong['lng'] : NULL
                                               ); //must put other parameters
        }
        else
        {
            //header('location: ' . URL . '______'); ______ is where the error page is if the listing could not update
            echo "Error could not update";
        }
        
        //where to go after song has been added
        header('location: ' . URL . 'post/index');
    }
}

