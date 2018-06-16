<?php

namespace App\Controllers;

use \Core\View;

class PageController extends \Core\Controller
{
	// Put properties here


	// Put Methods here
	public function aboutUsAction()
	{
		View::renderTemplate('Pages/home.html');
	}

	public function contactAction()
	{
		View::renderTemplate('Pages/contact.html');
	}
}