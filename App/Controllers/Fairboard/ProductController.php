<?php
/**
 * Created by PhpStorm.
 * User: JustinR
 * Date: 29-5-2018
 * Time: 21:56
 */

namespace App\Controllers\Fairboard;

use App\Models\Product;
use Core\View;

class ProductController extends \Core\Controller
{
    public function indexAction()
    {
        View::renderTemplate('Fairboard/Product/index.html', ["products" => Product::getAll()]);
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
        if (isset($_POST['name']) &&
            isset($_POST['purchPrice']) &&
            isset($_POST['salesPrice']) &&
            isset($_POST['rentalPrice']) &&
            isset($_POST['discount']) &&
            isset($_POST['description']))
        {
            $name = $_POST['name'];
            $purchPrice = $_POST['purchPrice'];
            $salesPrice = $_POST['salesPrice'];
            $rentalPrice = $_POST['rentalPrice'];
            $discount = $_POST['discount'];
            $description = $_POST['description'];

            $product = new Product(null, $name, $purchPrice, $salesPrice, $rentalPrice, $discount, $description);
            $product = $product->insert();
            if($product->getId() === null)
            {
                $responseArray = array('result' => 'success', 'type' => 'Product');
            }
            else
            {
                $responseArray = array('result' => 'fail', 'type' => 'Product');
            }

            $encoded = json_encode($responseArray);
            header('Content-Type: application/json');
            echo $encoded;
        }
        else
        {
            View::renderTemplate('Fairboard/Product/add.html');
        }
    }

}

