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

	public function fairDataAction()
	{
		View::renderTemplate('Fairsoft/Pages/fairData.html');
	}

	public function fairRentAction()
	{
		View::renderTemplate('Fairsoft/Pages/fairRent.html');
	}

	public function fairPayPlanAction()
	{
		View::renderTemplate('Fairsoft/Pages/fairPayPlan.html');
	}

	public function techSupportAction()
	{
		View::renderTemplate('Fairsoft/Pages/techSupport.html');
	}

	public function contactAction()
	{
		View::renderTemplate('Fairsoft/Pages/contact.html');
	}

	public function faqAction()
	{
		View::renderTemplate('Fairsoft/Pages/faq.html');
	}

	public function termsAction()
	{
		View::renderTemplate('Fairsoft/Pages/terms.html');
	}

	public function sitemapAction()
	{
		View::renderTemplate('Fairsoft/Pages/sitemap.html');
	}

	public function orderAndDeliveryAction()
	{
		View::renderTemplate('Fairsoft/Pages/orderAndDelivery.html');
	}

	public function paymentsAction()
	{
		View::renderTemplate('Fairsoft/Pages/payments.html');
	}
}