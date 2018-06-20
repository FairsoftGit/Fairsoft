<?php

namespace App\Controllers\Fairboard;

use \Core\View;

/**
 * PageController
 *
 * PHP version 7.0
 */
class PageController extends \Core\Controller
{
    /**
     * Before filter. Return false to stop the action from executing.
     *
     * @return void
     */
    protected function before()
    {
        if(!$this->isAuthenticated())
        {
            View::renderTemplate('General/requireLogin.html');
            return false;
        }
    }

    public function homeAction()
    {
        View::renderTemplate('Fairboard/home.html');
    }

    public function fairboardAction()
    {
        View::renderTemplate('Fairboard/home.html');
    }
}
