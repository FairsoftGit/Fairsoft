<?php

namespace App\Controllers\Fairboard;

use \Core\View;
use App\Models\Account;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class AccountController extends \Core\Controller
{
    public function loginAction()
    {
        if($this->isAuthenticated()){

            header('location: /');
            exit();
        }

        if (isset($_POST['Username']) && isset($_POST['Password'])) {
            $username = $_POST['Username'];
            $password = $_POST['Password'];
            $account = AccountController::login($username, $password);
            if (!is_null($account) && !empty($account->getUsername())) {
                $_SESSION["account"] = $account;
                $responseArray = array('result' => 'succes');
                $encoded = json_encode($responseArray);
                header('Content-Type: application/json');
                echo $encoded;
            } else {
                $responseArray = array('result' => 'fail');
                $encoded = json_encode($responseArray);
                header('Content-Type: application/json');
                echo $encoded;
            }
        } else {
            view::renderTemplate('account/login.html');
        }

    }
    public function logoutAction()
    {
        if(session_id()) {
            if (isset($_SESSION['account'])) {
                $account = $_SESSION['account'];
                //do something with the current session before destroy
            }
            // Unset all of the session variables.
            $_SESSION = array();

            // If it's desired to kill the session, also delete the session cookie.
            // Note: This will destroy the session, and not just the session data!
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            // Finally, destroy the session.
            session_destroy();
        }
        header('location: /account/login');
    }
}
