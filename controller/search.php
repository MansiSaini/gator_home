<?php

/**
 * Class Search
 * Displays the house listings for rent with filtering and map overview.
 * 
 */
class Search extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/songs/index
     */
    public function index()
    {
        // getting all the apartments
        $listings = $this->listingModel->getAllListings();
        $thumbnailItems = $this->thumbnailModel->getAllThumbnailMediaInfo();

        $items = self::formatListingThumbnailData($thumbnailItems);
       // load views. within the views we can echo out $songs and $amount_of_songs easily
        require APP . 'view/_templates/header.php';
        require APP . 'view/search/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function viewDetail($listing_id) {
        // if we have an id of a house then that should be viewed
        if (isset($listing_id)) {
            $listing = $this->listingModel->getListingById($listing_id);
            $mediaItems = $this->mediaModel->getMediaPaths($listing_id);
            $mediaItemIds = $this->mediaModel->getMediaIds($listing_id);
            $mediaArray = array();
            foreach ($mediaItemIds as $mediaId) {
                array_push($mediaArray, $mediaId->id);
            }
            $thumbnailItems = $this->thumbnailModel->getThumbnailPaths($mediaArray);
            require APP . 'view/_templates/header.php';
            require APP . 'view/search/detail.php'; 
            require APP . 'view/_templates/footer.php';
        } else {
            header('location: ' . URL . 'search/index');
        }        
    }

    public function searchListings() {
        $query = $_GET["search"];
        $listings = $this->listingModel->getListingsFromSearch($query);
        $thumbnailItems = $this->thumbnailModel->getAllThumbnailMediaInfo();
        $items = self::formatListingThumbnailData($thumbnailItems);       
        require APP . 'view/_templates/header.php';
        require APP . 'view/search/index.php';
        require APP . 'view/_templates/footer.php';
    }

    private function formatListingThumbnailData($thumbnailItems) {
        $items = array();
        foreach($thumbnailItems as $thumbnailItem) {
            $items[$thumbnailItem->listing_id] = $thumbnailItem->thumbnail_path;
        }
        return $items;
    }
    
    public function filterListings() {
        $filterValues = array();

        if (array_key_exists('furnished', $_GET)){
            $filterValues['is_furnished']=1;
        }
        if (array_key_exists('accessible', $_GET)){
            $filterValues['is_accessible']=1;
        }
        if (array_key_exists('smoking', $_GET)){
            $filterValues['is_smoke']=1;
        }
        if (array_key_exists('parking', $_GET)){
            $filterValues['has_parking']=1;
        }
        if (array_key_exists('options', $_GET)){
            switch ($_GET['options']) {
                case "recent":
                    $filterValues['most_recent']=1;
                    break;
                case "low":
                    $filterValues['price_low_to_high']=1;
                    break;
                case "high":
                    $filterValues['price_high_to_low']=1;
                    break;
                default:
                    $filterValues['most_recent']=1;
                    break;
            }
        }
        
        if (array_key_exists('minrange', $_GET)){
            $filterValues['min_price']=$_GET["minrange"];
        } else {
            $filterValues['min_price']=0;
        }
        if (array_key_exists('maxrange', $_GET)){
            $filterValues['max_price']=$_GET["maxrange"];
        } else {
            $filterValues['max_price']=5000;
        }
	if (array_key_exists('mindistance', $_GET)){
	    $filterValues['min_distance']=$_GET["mindistance"];
	} else {
	    $filterValues['min_distance']=0;
	}
 	if (array_key_exists('maxdistance', $_GET)){
	    $filterValues['max_distance']=$_GET["maxdistance"];
	} else {
	    $filterValues['max_distance']=20;
	}
        if (array_key_exists('search', $_GET)) {
            $filterValues['search'] = $_GET['search'];
            $query = $_GET['search'];
        }
        $listings = $this->listingModel->getListingsByFilters($filterValues);        
        require APP . 'view/_templates/header.php';
        require APP . 'view/search/index.php';
        require APP . 'view/_templates/footer.php';
    }
}
