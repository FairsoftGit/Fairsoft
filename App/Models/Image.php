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
    private $filename;
    private $size;
    private $extension;
    private $thumb_size;

    public static function getImageByProduct($productId, $size, $extension)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT image.id, image.filename, image.size, image.extension, image.thumb_size FROM image INNER JOIN product_image WHERE image.size = :size AND image.extension = :extension AND product_image.product_id = :productId AND product_image.image_id = image.id');
        $stmt->bindParam(':productId', $productId);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':extension', $extension);
        $stmt->execute();
        return $stmt->fetchObject('App\Models\Image');
    }

    public function getRelativePath()
    {
        return DIRECTORY_SEPARATOR . Config::IMAGE_FOLDER . DIRECTORY_SEPARATOR . $this->filename . $this->extension;
    }

    private function getServerPath()
    {
        return $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . Config::IMAGE_FOLDER . DIRECTORY_SEPARATOR . $this->filename . $this->extension;
    }

    public function getResolution()
    {
        return getimagesize($this->getServerPath());
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getSize()
    {
        return $this->size;
    }
    public function getExtension()
    {
        return $this->extension;
    }

    public function getThumb_size()
    {
        return $this->thumb_size;
    }
}
