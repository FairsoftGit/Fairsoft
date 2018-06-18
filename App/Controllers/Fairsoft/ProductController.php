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
	public function indexAction()
	{


		$id = $this->route_params["id"];
		$product = Product::constructFromDatabase($id);
		View::renderTemplate('Fairsoft/Pages/product.html', ["product" => $product]);
	}

}
