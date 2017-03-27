<?php
/**
 * Class Login
 *
 */
class Register extends Controller
{

    /**
     * PAGE: index
     */
    public function index()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/register/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function createUser() 
    {
            // if we have POST data to create a new user entry
            if (isset($_POST["submit_add_user"])) {

                // make sure the username or email is not already taken.
                $user = $this->userModel->getExistingUser(
                    $_POST["email"],
                    $_POST["uname"]
                );
                if ($user && $user->email == $_POST["email"]) {
                    $emailError = "This email address is already registered. ";
                    $emailError .= "Please use a different email address.";
                }
                if ($user && $user->user_name == $_POST["uname"]) {
                    $userError = "Username already exists. Please use a different username.";
                }
                if ($user) {
                    $form_fname = $_POST["fname"];
                    $form_lname = $_POST["lname"];
                    $form_email = $_POST["email"];
                    $form_user_name = $_POST["uname"];
                    require APP . 'view/_templates/header.php';
                    require APP . 'view/register/index.php';
                    require APP . 'view/_templates/footer.php';
                }
                else {
                    $this->userModel->addUser(
                    $_POST["fname"],
                    $_POST["lname"],
                    $_POST["uname"],
                    $_POST["password"],
                    $_POST["email"],
                    0
                    );
                    // where to go after user has been registered
                    header('location: ' . URL . 'login/index');
                }
            } else {
                header('location: ' . URL . 'register/index');
            
            }
    }

}
