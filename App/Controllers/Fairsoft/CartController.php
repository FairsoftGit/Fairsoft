<?php
/**
 * Created by PhpStorm.
 * User: SightVision
 * Date: 16-6-2018
 * Time: 11:55
 */

namespace App\Controllers\Fairsoft;

use App\Models\Product;
use \Core\Post;
use \Core\View;

/**
 * HomeController controller
 *
 * PHP version 7.0
 */
class CartController extends \Core\Controller
{

	const COOKIE_CART_NAME = 'shopping_cart_FS';
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


	public function addAction()
	{
		$posttime = time();
		$cookieName = self::COOKIE_CART_NAME;
		$productId = $this->route_params["id"];
		$quantity = Post::get('quantity');
		$products = [];

		if (!is_null($productId) && !is_null($quantity)) {    // Wel html form data ontvangen


			//Check if cookie exists
			if (isset($_COOKIE[$cookieName])) {    // Cookie bestaat al

				// Check if ProductId exists in cookie
				$products = json_decode($_COOKIE[$cookieName], TRUE);
				// place all existing productId's in new array
				$jsonKeys = array_column($products, 'id');
				// check if $product_id matches any id from cookie in $jsonKeys
				$idExists = in_array($productId, $jsonKeys);

				if ($idExists == true) {        // ProductId staat al in de cookie
					for ($i = 0; $i < count($products); $i++) {
						if ($products[$i]['id'] == $productId) {
							$products[$i]['quantity'] += $quantity;
						}
					}
				} else {    // ProductId staat nog niet in de cookie
					array_push($products, array("id" => $productId, "quantity" => $quantity));
				}

			} else {    // Cookie bestaat nog niet
				$products[0] = array("id" => $productId, "quantity" => $quantity);
			}

			$json = json_encode($products);
			setcookie($cookieName, $json, $posttime + (86400 * 30), "/");
		} else {    // Geen data uit html form ontvangen
			echo "Er is geen formulier data ontvangen!";
		}
		$this->returnToReferer();
	}

	public function editAction()
	{
		$productId = $this->route_params["id"];

		if (!is_null($productId)) {
			$cookieName = self::COOKIE_CART_NAME;
			$cookie = array();
			if (isset($_COOKIE[$cookieName])) {
				$oldCookie = $_COOKIE[$cookieName];
				$products = json_decode($oldCookie);
				foreach ($products as $product) {
					if ($productId === $product->id) {
						$product->quantity = $_POST['newQuantity'];
					}
					array_push($cookie, $product);
				}
				$cookie = json_encode($cookie);
				setcookie($cookieName, $cookie, time() + (86400 * 2), '/'); // 86400 = 1 dag
			}
		}
		$this->returnToReferer();
	}

	public function deleteAction()
	{
		$productId = $this->route_params["id"];

		if (!is_null($productId)) {
			$cookieName = self::COOKIE_CART_NAME;
			$cookie = array();
			if (isset($_COOKIE[$cookieName])) {
				$oldCookie = $_COOKIE[$cookieName];
				$products = json_decode($oldCookie);
				foreach ($products as $product) {
					if ($productId === $product->id) {
						continue;
					}
					array_push($cookie, array('id' => $product->id, 'quantity' => $product->quantity));
				}
				if(count($cookie) <= 0)
				{
					//Delete the cookie if there are no values
					setcookie($cookieName, $oldCookie, 1, '/'); // 86400 = 1 day
				}
				else
				{
					$cookie = json_encode($cookie);
					setcookie($cookieName, $cookie, time() + (86400 * 2), '/'); // 86400 = 1 day
				}
			}
		}
		$this->returnToReferer();
	}

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