<?php
/**
 * Created by PhpStorm.
 * User: JustinR
 * Date: 29-5-2018
 * Time: 21:56
 */

namespace App\Controllers\Fairboard;

use App\Models\Product;
use Core\Post;
use Core\View;

class ProductController extends \Core\Controller
{
    protected function before()
    {
        if (!$this->isAuthenticated()) {
            View::renderTemplate('General/requireLogin.html');
            return false;
        }
    }

    public function indexAction()
    {
        $products = Product::getAllWithStock();
        View::renderTemplate('Fairboard/Product/index.html', ["products" => $products]);
    }

    public function deleteAction()
    {
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            Product::delete($id);

            $responseArray = array('result' => 'succes');
            $encoded = json_encode($responseArray);
            header('Content-Type: application/json');
            echo $encoded;
        }
    }

    public function addAction()
    {
        if (Post::get('name') &&
            Post::get('purchPrice') &&
            Post::get('salesPrice') &&
            Post::get('rentalPrice') &&
            Post::get('discount') &&
            Post::get('description')) {

            $product = new Product(
                null,
                Post::get('name'),
                Post::get('purchPrice'),
                Post::get('salesPrice'),
                Post::get('rentalPrice'),
                Post::get('discount'),
                Post::get('description'));

            $product = $product->insert();
            if (is_null($product->getId())) {
                $responseArray = array('result' => 'fail', 'message' => 'Er is iets mis gegaan tijdens het opslaan.');
            } else {
                $responseArray = array('result' => 'success', 'message' => '');
            }
            $encoded = json_encode($responseArray);
            header('Content-Type: application/json');
            echo $encoded;
        } else {
            View::renderTemplate('Fairboard/Product/add.html');
        }
    }

}

