<?php
/**
 * Created by PhpStorm.
 * User: SightVision
 * Date: 16-6-2018
 * Time: 11:55
 */

namespace App\Controllers\Fairsoft;

use App\Models\Product;
use \Core\View;

/**
 * HomeController controller
 *
 * PHP version 7.0
 */
class CartController extends \Core\Controller
{

	/**
	 * Before filter. Return false to stop the action from executing.
	 *
	 * @return void
	 */
	protected function before()
	{
	}

	/**
	 * Show the index page
	 *
	 * @return void
	 */
	public function showCartAction()
	{
		$cookieName = 'Fairsoft_shopping_cart';
		if(isset($_COOKIE[$cookieName])) {
				$products = json_decode($_COOKIE[$cookieName], TRUE);
		} else {
			$products = "";
		}
		var_dump($products);
		//View::renderTemplate('Fairsoft/Pages/cart.html', ["products" => $products]);
	}

}