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
    }

    public function indexAction()
    {
        View::renderTemplate('Fairboard/index.html');
    }

    public function fairboardAction()
    {
        View::renderTemplate('Fairboard/index.html');
    }
}
