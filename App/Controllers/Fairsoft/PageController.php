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

	public function sendFormEmailAction(){
		if(isset($_POST['email'])) {
			$email_to = "jhel@avans.nl";
			$email_subject = "Contactformulier van www.fairsoft.nl";

			function died($error) {
				// your error code can go here
				$errorMsg = "We are very sorry, but there were error(s) found with the form you submitted. These errors appear below.<br /><br /> $error.<br /><br />Please go back and fix these errors.<br /><br />";
				View::renderTemplate('Fairsoft/Pages/formSubmit.html', ["Msg" => $errorMsg]);
				die();
			}

			function success()
			{
				$successMsg = "Uw bericht is ontvangen. Wij zullen zo spoedig mogelijk met u contact opnemen.";
				View::renderTemplate('Fairsoft/Pages/formSubmit.html', ["Msg" => $successMsg]);
			}

			// validation expected data exists
			if(!isset($_POST['name']) ||
				!isset($_POST['email']) ||
				!isset($_POST['text'])) {
				died('We are sorry, but there appears to be a problem with the form you submitted.');
			}

			$name = $_POST['name']; // required
			$email_from = $_POST['email']; // required
			$telephone = $_POST['phone']; // not required
			$comments = $_POST['text']; // required

			$error_message = "";
			$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

			if(!preg_match($email_exp,$email_from)) {
				$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
			}

			$string_exp = "/^[A-Za-z .'-]+$/";

			if(!preg_match($string_exp,$name)) {
				$error_message .= 'The First Name you entered does not appear to be valid.<br />';
			}

			if(strlen($comments) < 2) {
				$error_message .= 'The Comments you entered do not appear to be valid.<br />';
			}

			if(strlen($error_message) > 0) {
				died($error_message);
			}

			$email_message = "Form details below.\n\n";

			function clean_string($string) {
				$bad = array("content-type","bcc:","to:","cc:","href");
				return str_replace($bad,"",$string);
			}

			$email_message .= "Name: ".clean_string($name)."\n";
			$email_message .= "Email: ".clean_string($email_from)."\n";
			$email_message .= "Telephone: ".clean_string($telephone)."\n";
			$email_message .= "Comments: ".clean_string($comments)."\n";

			// create email headers
			$headers = 'From: '.$email_from."\r\n".
			'Reply-To: '.$email_from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			@mail($email_to, $email_subject, $email_message, $headers);

			success();

		} else {
			died('Er is geen e-mailadres ingevuld.');
		}
	}
}