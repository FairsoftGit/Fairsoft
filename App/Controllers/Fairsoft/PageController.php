<?php

namespace App\Controllers\Fairsoft;

use \Core\View;

class PageController extends \Core\Controller
{
	public function aboutUsAction()
	{
		View::renderTemplate('Fairsoft/Pages/home.html');
	}

	public function howItWorksAction()
	{
		View::renderTemplate('Fairsoft/Pages/howItWorks.html');
	}

	public function techSupportAction()
	{
		View::renderTemplate('Fairsoft/Pages/techSupport.html');
	}

	public function contactAction()
	{
		View::renderTemplate('Fairsoft/Pages/contact.html');
	}
}