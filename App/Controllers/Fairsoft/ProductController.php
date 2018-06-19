<?php
/**
 * Created by PhpStorm.
 * User: SightVision
 * Date: 16-6-2018
 * Time: 11:55
 */

namespace App\Controllers\Fairsoft;

use App\Models\Product;
use Core\Post;
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
        $product_id = $this->route_params["id"];
        $quantity = Post::get('quantity');

        if (!is_null($product_id) && !is_null($quantity)) {
            $cookieName = 'Fairsoft_shopping_cart';
            $cookie = array();
            //Als de cookie al bestaat dan de quantity ophogen en alle items in een nieuwe array stoppen
            if (isset($_COOKIE[$cookieName])) {
                $products = json_decode($_COOKIE[$cookieName]);

                foreach ($products as $product) {
                    if ($product_id === $product->id) {
                        $product->quantity = $product->quantity + $quantity;
                    }
                    array_push($cookie, array('id' => $product->id, 'quantity' => $product->quantity));
                }
            } else {
                array_push($cookie, array('id' => $product_id, 'quantity' => $quantity));
            }
            $cookie = json_encode($cookie);
            setcookie($cookieName, $cookie, time() + (86400 * 2)); // 86400 = 1 day
        }
        $this->returnToReferer();
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
