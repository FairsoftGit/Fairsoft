<?php
namespace App\Models;
use PDO;

class Language extends \Core\Model
{
    private $id, $code, $locale, $description;

    private function __construct($id, $code, $locale, $description)
    {
        $this->id = $id;
        $this->code = $code;
        $this->locale = $locale;
        $this->description = $description;
    }

    public static function getAvailable()
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare('SELECT * from `language`');
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Models\Language', [null, null, null, null]);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
        }
    }

    public function getId()
    {
        return $this->id;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function getLocale()
    {
        return $this->locale;
    }
    public function getDescription()
    {
        return $this->description;
    }
}
