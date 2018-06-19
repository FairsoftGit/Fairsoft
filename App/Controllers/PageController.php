<?php

namespace App\Controllers;

use \Core\View;

class PageController extends \Core\Controller
{
	public function aboutUsAction()
	{
		View::renderTemplate('Pages/home.html');
	}

	public function howItWorksAction()
	{
		View::renderTemplate('Pages/howItWorks.html');
	}

	public function techSupportAction()
	{
		View::renderTemplate('Pages/techSupport.html');
	}

	public function contactAction()
	{
		View::renderTemplate('Pages/contact.html');
	}
}