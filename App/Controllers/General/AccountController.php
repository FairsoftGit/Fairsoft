<?php

namespace App\Controllers\General;

use \Core\Session;
use \Core\View;
use \App\Models\Account;
use \Core\Post;

class AccountController extends \Core\Controller
{
    public function loginAction()
    {
        if ($this->isAuthenticated()) {
            header('location: /');
            exit();
        }

        if (Post::get('Username') && Post::get('Password')) {
            $username = Post::get('Username');
            $password = Post::get('Password');
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

    public function setLanguageAction()
    {
        $code = $this->route_params["language"];
        $language = $this->getLanguageByCode($code);
        if(!is_null($language))
        {
            Session::set('locale', $language->getLocale());
        }
        $this->returnToReferer();
    }
}
