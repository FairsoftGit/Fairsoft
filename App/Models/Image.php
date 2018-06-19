<?php

namespace App\Models;

use App\Config;
use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Image extends \Core\Model
{
    private $id;
    private $name;
    private $size;
    private $extension;

    public static function getImageByProduct($productId, $size, $extension)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT image.id, image.name, image.size, image.extension FROM image INNER JOIN product_image WHERE image.size = :size AND image.extension = :extension AND product_image.productId = :productId AND product_image.imageId = image.id');
        $stmt->bindParam(':productId', $productId);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':extension', $extension);
        $stmt->execute();
        return $stmt->fetchObject('App\Models\Image');
    }

    public function getRelativePath()
    {
        return DIRECTORY_SEPARATOR . Config::IMAGE_FOLDER . DIRECTORY_SEPARATOR . $this->name . $this->extension;
    }

    private function getServerPath()
    {
        return $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . Config::IMAGE_FOLDER . DIRECTORY_SEPARATOR . $this->name . $this->extension;
    }

    public function getResolution()
    {
        return getimagesize($this->getServerPath());
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSize()
    {
        return $this->size;
    }
    public function getExtension()
    {
        return $this->extension;
    }
}
