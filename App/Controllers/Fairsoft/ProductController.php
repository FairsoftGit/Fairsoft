<?php
/**
 * Created by PhpStorm.
 * User: SightVision
 * Date: 16-6-2018
 * Time: 11:55
 */

namespace App\Controllers\Fairsoft;

use App\Models\Product;
use Core\Error;
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

    /**
     * Show the index page
     *
     * @return void
     */
    private function showProductPageById($id)
    {
        $product = Product::constructFromDatabase($id);
        if(is_null($product))
        {
            throw new \Exception('Er is helaas een fout opgetreden op de pagina', 500);
        }
        View::renderTemplate('Fairsoft/Pages/product.html', ["product" => $product]);
    }

    public function fairVestAction()
    {
        $this->showProductPageById(1);
    }

    public function fairBoxAction()
    {
        $this->showProductPageById(2);
    }

    public function fairGoggles()
    {
        $this->showProductPageById(3);
    }

    public function fairApp()
    {
        $this->showProductPageById(4);
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
            setcookie($cookieName, $cookie, time() + (86400 * 2), '/'); // 86400 = 1 day
        }
        $this->returnToReferer();
    }

    public function deleteAction()
    {
        $product_id = $this->route_params["id"];

        if (!is_null($product_id)) {
            $cookieName = 'Fairsoft_shopping_cart';
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
                if (count($cookie) <= 0) {
                    //Delete the cookie if there are no values
                    setcookie($cookieName, $oldCookie, 1, '/'); // 86400 = 1 day
                } else {
                    $cookie = json_encode($cookie);
                    setcookie($cookieName, $cookie, time() + (86400 * 2), '/'); // 86400 = 1 day
                }
            }
        }
        $this->returnToReferer();
    }
}
