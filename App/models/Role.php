<?php

namespace App\Models;

use PDO;

class Role extends \Core\Model
{
    protected $permissions;
    private $id, $role, $created, $modified;

    protected function __construct() {
        $this->permissions = array();
    }

    // return a role object with associated permissions
    public static function getRolePerms($roleId) {
        $roleObject = new Role();
        $db = static::getDB();
        $stmt = $db->prepare('SELECT `permissionId` FROM role_permission WHERE `roleId` = :roleId');
        $stmt->bindParam(':roleId', $roleId);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $roleObject->permissions[$row["permissionId"]] = true;
        }
        return $roleObject;
    }

    // check if a permission is set
    public function hasPerm($permission) {
        return isset($this->permissions[$permission]);
    }

    /**
     * Get all the all the roles as an associative array
     * @return array
     */
    public static function getAll()
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare('select `id`, `role`, `created` `modified` from role');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'App\Models\Role');
        } catch (PDOException $e) {
        }
    }

    /**
     * Get specific Product by id
     * @param $id
     * @return array
     */
    public static function getRoleById($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT `id`, `role`, `created` `modified` FROM role WHERE `id` = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject('App\Models\Role');
    }

    /**
     * Update Product
     * @param $id
     * @param $name
     * @param $price
     */
    public static function update($id, $role)
    {
        $ret = 'succes';
        try {
            $db = static::getDB();
            $db->beginTransaction();
                $stmt = $db->prepare('update role set `role` = :role where `id` = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
            $db->commit();
            }
        catch (PDOException $e) {
            throw new \Exception('Fout opgetreden tijdens update.');
        }
        return $ret;
    }

    /**
     * Check if role exists
     * @param $role
     * @return integer //1 if exists else 0
     */
    public
    static function exists($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT EXISTS ( SELECT `id` from role WHERE  `id` = :id ) as result');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insert role
     * @param $role
     * @return boolean result
     */
    public
    static function insert($role)
    {
        try {
            $ret = 'succes';
            $db = static::getDB();
            $db->beginTransaction();
            if (self::exists($role)['result'] == 0) {
                $stmt = $db->prepare('insert into role (`role`) values (:role)');
                $stmt->bindParam(':role', $role);
                $stmt->execute();
            } else {
                $ret = 'duplicate';
            }
            $db->commit();
            return $ret;
        } catch (PDOException $e) {
            throw new \Exception('Fout opgetreden tijdens insert.');
        }
    }

    /**
     * Delete role
     * @param $role
     */
    public
    static function delete($role)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare('DELETE FROM role WHERE `role` = :role');
            $stmt->bindParam(':role', $role);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception('Fout opgetreden tijdens delete.');
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getModified()
    {
        return $this->modified;
    }
}
