<?php

namespace App\Controllers\Fairboard;

use App\Models\Product;
use \Core\View;
use App\Models\Item;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class ItemController extends \Core\Controller
{
    /**
     * Before filter. Return false to stop the action from executing.
     *
     * @return void
     */
    protected function before()
    {
        if(!$this->isAuthenticated()){
            header('location: /account/login');
            return false;
        }
        $account = $_SESSION['account'];
        return $account->hasPrivilege("Product");
    }


    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        if(isset($_GET['Product_id']))
        {
            $product_id = intval($_GET['Product_id']);
            View::renderTemplate('item/index.html', ['items' => ItemController::getByProduct($product_id)]);
        }
        else
        {
            View::renderTemplate('item/index.html', ['items' => ItemController::getAll() ]);
        }
    }

    public function editAction()
    {
        $id = intval($_GET['id']);
        View::renderTemplate('item/edit.html', ['item' => ItemController::get($id)]);
    }

    public function addAction()
    {
        View::renderTemplate('item/add.html', ['products' => Product::getAll()]);
    }

    public function insertAction()
    {
        if (isset($_POST['Serial_code']) && isset($_POST['Product_id']))
        {
            $serial_code = $_POST['Serial_code'];
            $product_id = intval($_POST['Product_id']);

            $responseArray = array('result' => ItemController::insert($serial_code, $product_id), 'type' => 'ItemController');

            $encoded = json_encode($responseArray);
            header('Content-Type: application/json');
            echo $encoded;
        }
    }

    public function deleteAction()
    {
        if(isset($_GET['Serial_code']))
        {
            $serial_code = $_GET['Serial_code'];
            ItemController::delete($serial_code);
            header('location: /item/index');
        }
    }
}
