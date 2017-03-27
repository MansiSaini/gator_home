<?php

/**
 * Class Account
 *
 */
class Account extends Controller
{
    /**
     * PAGE: index
     */
    public function index()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/account/index.php';
        require APP . 'view/_templates/footer.php';
    }
}