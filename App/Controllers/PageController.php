<?php

namespace App\Controllers;

use \Core\View;

class PageController extends \Core\Controller
{
	// Put properties here


	// Put Methods here
	public function howItWorksAction()
	{
		View::renderTemplate('Pages/fs/howItWorks.html');
	}

}