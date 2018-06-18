<?php

namespace App\Controllers\General;

use Core\Session;
use \Core\View;
use App\Models\Account;

class AccountController extends \Core\Controller
{
    public function loginAction()
    {
        if ($this->isAuthenticated()) {
            header('location: /');
            exit();
        }

        if (isset($_POST['Username']) && isset($_POST['Password'])) {
            $username = $_POST['Username'];
            $password = $_POST['Password'];
            $account = Account::login($username, $password);
            if (!is_null($account) && !empty($account->getUsername())) {
                Session::set('account', $account);
                $responseArray = array('result' => 'success');
            } else {
                $responseArray = array('result' => 'fail');
            }
            $encoded = json_encode($responseArray);
            header('Content-Type: application/json');
            echo $encoded;
        } else {
            view::renderTemplate('General/Account/login.html');
        }
    }

    public function logoutAction()
    {
        Session::clear();
        header('location: /');
    }
}
