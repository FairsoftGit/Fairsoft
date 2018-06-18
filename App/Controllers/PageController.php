<?php

namespace App\Controllers;

use \Core\View;

class PageController extends \Core\Controller
{
	public function aboutUsAction()
	{
		View::renderTemplate('Pages/home.html', ['available_languages' => $this->available_languages]);
	}

	public function howItWorksAction()
	{
		View::renderTemplate('Pages/howItWorks.html', ['available_languages' => $this->available_languages]);
	}

	public function techSupportAction()
	{
		View::renderTemplate('Pages/techSupport.html', ['available_languages' => $this->available_languages]);
	}

	public function contactAction()
	{
		View::renderTemplate('Pages/contact.html', ['available_languages' => $this->available_languages]);
	}
}