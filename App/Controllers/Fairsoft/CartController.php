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
		$cookieName = 'shopping_cart_FS';
		if(isset($_COOKIE[$cookieName])) {
				$products = json_decode($_COOKIE[$cookieName], TRUE);

				//Get product details from database
				for($i=0; $i<count($products); $i++) {
					$id = $products[$i]['id'];
					$product = Product::constructFromDatabase($id);
					$products[$i]['name'] = $product->getProductName();
					$products[$i]['price'] = $product->getSalesPrice();
					$products[$i]['imgUrl'] = $product->getImgUrl();
					$products[$i]['rowTotal'] = $products[$i]['price'] * $products[$i]['quantity'];
				}
		} else {
			$products = "";
		}
		View::renderTemplate('Fairsoft/Pages/cart.html', ["products" => $products]);
	}

}