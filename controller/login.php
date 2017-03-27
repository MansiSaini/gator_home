<?php

/**
 * Class Login
 *
 */
class Login extends Controller
{
    /**
     * PAGE: index
     */
    public function index()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/login/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function verifyUser() {
        if (isset($_POST["submit_login_user"])) {
            $user = $this->userModel->getUser(
                $_POST["uname"],
                $_POST["password"]
            );
            if ($user) {
                session_start();
                $_SESSION['first_name'] = $user->first_name;
                $_SESSION['user_name'] = $user->user_name;
                $_SESSION['last_name'] = $user->last_name;
                $_SESSION['email'] = $user->email;
                $_SESSION['is_logged_in'] = 1;
                $_SESSION['user_id'] = $user->id;
                if (! strpos($_POST["referer"], 'register') & (strpos($_POST["referer"], 'post') >= 0 || strpos($_POST["referer"], 'contact') >= 0)){
                    header('location:' . $_POST["referer"]);
                }
                else {
                    header('location: ' . URL . 'home/');
                }
            }
            else {
                // where to go after user has been registered
                $errorMessage = "Invalid username and/or password.";
                $httpReferer = $_POST["referer"]; // Save the referer for further use.
                require APP . 'view/_templates/header.php';
                require APP . 'view/login/index.php';
                require APP . 'view/_templates/footer.php';                            
            }
        }
    }
}