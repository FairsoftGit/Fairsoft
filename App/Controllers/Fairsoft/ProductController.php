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
		$cookieName = "test2";
		$productId = $this->route_params["id"];
		$quantity = Post::get('quantity');
		$products = [];

		if (!is_null($productId) && !is_null($quantity)) { 								// Wel html form data ontvangen
			echo "Formulier data is ontvangen: Id: $productId / Aantal: $quantity <br><hr>";

			//Check if cookie exists
			if(isset($_COOKIE[$cookieName])) {											// Cookie bestaat al
				echo "Cookie $cookieName bestaat al. <br><hr>";

				// Check if ProductId exists in cookie
				$products = json_decode($_COOKIE[$cookieName], TRUE);
				// place all existing productId's in new array
				$jsonKeys = array_column ($products, 'id');
				// check if $product_id matches any id from cookie in $jsonKeys
				$idExists = in_array($productId, $jsonKeys);
				if($idExists == true) {													// ProductId staat al in de cookie
					echo "ProductId $productId staat al in de cookie. <br><hr>";

					for($i=0; $i<count($products); $i++) {
						if($products[$i]['id'] == $productId) {
							$products[$i]['quantity'] += $quantity;
						}
					}

				} else {																// ProductId staat nog niet in de cookie
					echo "ProductId $productId staat nog niet in de cookie. <br><hr>";

					array_push($products, array("id" => $productId, "quantity" => $quantity));
				}

			} else {																	// Cookie bestaat nog niet
				echo "Cookie $cookieName bestaat nog niet. <br><hr>";
				$products[0] = array("id" => $productId, "quantity" => $quantity);
			}

			$json = json_encode($products);
			setcookie($cookieName, $json, $posttime + (86400 * 30), "/");
			echo "<a href='/cookie'>Naar CookieViewer<a/>";
			print_r($_COOKIE);
		} else { 																		// Geen data uit html form ontvangen
			echo "Er is geen formulier data ontvangen!";
		}
    }

    public function readCookiesAction(){
    	echo "<a href='/'>Terug</a><hr><hr>";
    	print_r($_COOKIE);

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
