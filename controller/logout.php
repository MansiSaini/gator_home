<?php

/**
 * Class Logout
 *
 */
class Logout extends Controller
{
    /**
     * PAGE: index
     */

    public function endUserSession() {

        //session_destroy(); // Is Used To Destroy All Session
        session_start();
        if(isset($_SESSION['is_logged_in'])) {
            session_destroy();
        }
        header('location: ' . URL . 'home/');
    }
}