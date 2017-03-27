<?php

/**
 * Class Support
 *
 */
class Support extends Controller
{
    
    /**
     * PAGE: index
     */
    public function faq()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/support/faq.php';
        require APP . 'view/_templates/footer.php';
    }

    public function privacy()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/support/privacy.php';
        require APP . 'view/_templates/footer.php';
    }

    public function terms()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/support/terms.php';
        require APP . 'view/_templates/footer.php';
    }
}