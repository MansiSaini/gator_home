<?php

/**
 * Class Profile
 *
 */
class Profile extends Controller
{
    /**
     * PAGE: index
     */
    public function index()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/profile/index.php';
        require APP . 'view/_templates/footer.php';
    }
}