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


}
