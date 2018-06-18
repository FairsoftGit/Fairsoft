<?php

namespace App\Controllers\Fairboard;
use App\Models\Role;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class RoleController extends \Core\Controller
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
        View::renderTemplate('RoleController/index.html', ['roles' => RoleController::getAll(), 'account' => $_SESSION['account'] ]);
    }

    public function addAction()
    {
        View::renderTemplate('RoleController/add.html');
    }

    public function insertAction()
    {
        if (isset($_POST['RoleController']))
        {
            $role = $_POST['RoleController'];
            $responseArray = array('result' => RoleController::insert($role), 'type' => 'Rol');

            $encoded = json_encode($responseArray);
            header('Content-Type: application/json');
            echo $encoded;
        }
    }

    public function deleteAction()
    {
        if(isset($_POST['Key']))
        {
            $key = $_POST['Key'];
            $responseArray = array('result' => RoleController::delete($key), 'type' => 'Rol');

            $encoded = json_encode($responseArray);
            header('Content-Type: application/json');
            echo $encoded;

        }
    }

}
