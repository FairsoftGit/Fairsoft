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
        $responseArray = array('result' => 'success');
        if(!$this->isAuthenticated())
        {
            if (Post::get('Username') && Post::get('Password')) {
                $username = Post::get('Username');
                $password = Post::get('Password');
                $account = Account::login($username, $password);
                if (!is_null($account) && !is_null($account->getId())) {
                    Session::set('account', $account);
                } else {
                    $responseArray = array('result' => 'fail');
                }
            } else {
                view::renderTemplate('General/Account/login.html');
                exit();
            }
        }
        header('Content-Type: application/json');
        echo json_encode($responseArray);
    }

    public function logoutAction()
    {
        Session::clear();
        $this->returnToReferer();
    }

    public function setLanguageAction()
    {
        $code = $this->route_params["language"];
        $language = $this->getLanguageByCode($code);
        if (!is_null($language)) {
            Session::set('locale', $language->getLocale());
        }
        $this->returnToReferer();
    }
}
