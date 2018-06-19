<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Permission extends \Core\Model
{
    /**
     * Get all the all the permissions
     * @return object array
     */
    public static function getAll()
    {
        try {
            $db = static::getDB();
            $stmt = $db->query('select `permission` from permission');
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
        }
    }

    /**
     * Get permission
     * @param $permission
     * @return permission
     */
    public static function get($permission)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT `permission` FROM permission WHERE `permission` = :permission');
        $stmt->bindParam(':permission', $permission);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Check if permission exists
     * @param $permission
     * @return integer //1 if exists else 0
     */
    public static function exists($permission)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT EXISTS ( SELECT `permission` from permission WHERE  `permission` = :permission ) as result');
        $stmt->bindParam(':permission', $permission);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insert permission
     * @param $permission
     * @return exception if thrown
     */
    public static function insert($permission)
    {
        try {
            $ret = 'succes';
            $db = static::getDB();
            $db->beginTransaction();
            if (self::exists($permission)['result'] == 0) {
                $stmt = $db->prepare('insert into permission (`permission`) VALUES (:permission)');
                $stmt->bindParam(':permission', $permission);
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
     * Delete permission
     * @param $permission
     */
    public
    static function delete($permission)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare('DELETE FROM permission WHERE `permission` = :permission');
            $stmt->bindParam(':permission', $permission);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception('Fout opgetreden tijdens delete.');
        }
    }
}
