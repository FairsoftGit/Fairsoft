<?php

namespace App\Controllers\General;

use \Core\Session;
use \Core\View;

class ShoppingController extends \Core\Controller
{
   public function basketAction()
   {
       View::renderTemplate('General/basket.html');
   }
}
