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
class ProductController extends \Core\Controller
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

    public function deleteAction()
    {
        $product_id = $this->route_params["id"];

        if (!is_null($product_id)) {
            $cookieName = self::COOKIE_CART_NAME;
            $cookie = array();
            if (isset($_COOKIE[$cookieName])) {
                $oldCookie = $_COOKIE[$cookieName];
                $products = json_decode($oldCookie);
                foreach ($products as $product) {
                    if ($product_id === $product->id) {
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

    public function readCookiesAction(){
    	echo "<a href='/'>Terug</a><hr><hr>";
    	if(isset($_COOKIE[self::COOKIE_CART_NAME])) {
			print_r($_COOKIE[self::COOKIE_CART_NAME]);
		} else {
    		echo "No products in cookies stored yet!";
		}
	}
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $id = $this->route_params["id"];
        $product = Product::constructFromDatabase($id);
        View::renderTemplate('Fairsoft/Pages/product.html', ["product" => $product]);
    }

}
