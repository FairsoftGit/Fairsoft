<?php

namespace App\Controllers;

use \Core\View;

class PageController extends \Core\Controller
{
	// Put properties here


	// Put Methods here
	public function aboutUsAction()
	{
		View::renderTemplate('Pages/fs/home.html');
	}

	public function howItWorksAction()
	{
		View::renderTemplate('Pages/fs/howItWorks.html');
	}

	// producten en diensten

	public function techSupportAction()
	{
		View::renderTemplate('Pages/fs/techSupport.html');
	}

	public function contactAction()
	{
		View::renderTemplate('Pages/fs/contact.html');
	}
}