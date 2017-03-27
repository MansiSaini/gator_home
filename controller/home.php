<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // getting all the apartments
        $listings = $this->listingModel->getAllListings();
        $thumbnailItems = $this->thumbnailModel->getAllThumbnailMediaInfo();

        $items = self::formatListingThumbnailData($thumbnailItems);
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/index.php';
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

    private function formatListingThumbnailData($thumbnailItems) {
        $items = array();
        foreach($thumbnailItems as $thumbnailItem) {
            $items[$thumbnailItem->listing_id] = $thumbnailItem->thumbnail_path;
        }
        return $items;
    }

    /**
     * PAGE: exampleone
     * This method handles what happens when you move to http://yourproject/home/exampleone
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function exampleOne()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/example_one.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * PAGE: exampletwo
     * This method handles what happens when you move to http://yourproject/home/exampletwo
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function exampleTwo()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/example_two.php';
        require APP . 'view/_templates/footer.php';
    }
}
