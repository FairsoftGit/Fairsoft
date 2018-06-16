<?php
/**
 * Created by PhpStorm.
 * User: SightVision
 * Date: 16-6-2018
 * Time: 11:50
 */

namespace App\Models;

use PDO;

class Product extends \Core\Model
{

	// Properties
	private $id;
	private $name;
	private $description;
	private $description_en;
	private $salesPrice;
	private $filename;
	private $extension;
	private $size;
	private $thumb_size;

	// Methods
	public static function constructFromDatabase($id)
	{
		$db = static::getDB();
		$stmt = $db->prepare('
			SELECT
				`product`.id,
				`product`.name,
				`product`.description,
				`product`.description_en,
				`product`.salesPrice,
				`image`.filename,
				`image`.extension,
				`image`.size,
				`image`.thumb_size
			FROM
				`product`
			  LEFT JOIN
				`product_image` ON `product_image`.product_id = `product`.id
			  LEFT JOIN
				`image` ON `image`.id = `product_image`.image_id
			WHERE
				`product`.id = :id');
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		return $stmt->fetchObject('App\Models\Product');
	}

	public function getProductId()
	{
		return $this->id;
	}

	public function getProductName()
	{
		return $this->name;
	}

	public function getProductDesc()
	{
		return $this->description;
	}

	public function getProductDesc_en()
	{
		return $this->description_en;
	}

	public function getsalesPrice()
	{
		return $this->salesPrice;
	}

	public function getImgUrl()
	{
		$fileName = $this->filename;
		$imgExt = $this->extension;
		return "../img/" . $fileName . "." . $imgExt;
	}

	public function getImgSize()
	{
		return $this->size;
	}

	public function getThumbSize()
	{
		return $this->thumb_size;
	}
}