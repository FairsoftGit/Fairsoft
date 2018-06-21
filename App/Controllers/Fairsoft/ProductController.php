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

    private function showProductPageById($id)
    {
        $product = Product::constructFromDatabase($id);
        $image = $product->getImage(849, '.png');
        if(is_null($product) || is_null($image))
        {
            throw new \Exception('Product is null', 500);
        }
        View::renderTemplate('Fairsoft/Pages/product.html', ["product" => $product, "image" => $image]);
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


}
