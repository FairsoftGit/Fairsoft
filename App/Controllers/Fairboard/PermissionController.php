<?php

namespace App\Controllers\Fairboard;
use App\Models\Permission;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class PermissionController extends \Core\Controller
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
        View::renderTemplate('PermissionController/index.html', ['permissions' => PermissionController::getAll(), 'account' => $_SESSION['account'] ]);
    }

    public function addAction()
    {
        View::renderTemplate('PermissionController/add.html');
    }

    public function insertAction()
    {
        if (isset($_POST['PermissionController']))
        {
            $permission = $_POST['PermissionController'];

            $responseArray = array('result' => PermissionController::insert($permission), 'type' => 'Permissie');

            $encoded = json_encode($responseArray);
            header('Content-Type: application/json');
            echo $encoded;
        }
    }

    public function deleteAction()
    {
        if(isset($_POST['PermissionController']))
        {
            $permission = $_POST['PermissionController'];
            PermissionController::delete($permission);
        }
    }

}
