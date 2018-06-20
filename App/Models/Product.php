<?php

namespace App\Models;

use PDO;

class Product extends \Core\Model
{
    private $id;
    private $name;
    private $purchPrice;
    private $salesPrice;
    private $rentalPrice;
    private $discount;
    private $description;
    private $description_en;
    private $created;
    private $modified;
    public $stock;
//	private $filename;
//	private $extension;
//	private $size;
//	private $thumb_size;

    public function __construct($id, $name, $purchPrice, $salesPrice, $rentalPrice, $discount, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->purchPrice = $purchPrice;
        $this->salesPrice = $salesPrice;
        $this->rentalPrice = $rentalPrice;
        $this->discount = $discount;
        $this->description = $description;
    }

    public static function constructFromDatabase($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('
			SELECT
				`product`.id,
				`product`.name,
				`product`.purchPrice,
				`product`.salesPrice,
				`product`.rentalPrice,
				`product`.discount,
				`product`.description,
				`product`.description_en,
				`product`.created,
				`product`.modified
			FROM
				`product`
			WHERE
				`product`.id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Models\Product', [null, null, null, null, null, null, null]);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function insert()
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare('INSERT INTO product (name, purchPrice, salesPrice, rentalPrice, discount, description)
                                  VALUES (:name, :purchPrice, :salesPrice, :rentalPrice, :discount, :description)');
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':purchPrice', $this->purchPrice);
            $stmt->bindParam(':salesPrice', $this->salesPrice);
            $stmt->bindParam(':rentalPrice', $this->rentalPrice);
            $stmt->bindParam(':discount', $this->discount);
            $stmt->bindParam(':description', $this->description);
            $stmt->execute();
        }
        catch (PDOException $e)
        {
        }
    }
    public static function getAllWithStock()
    {
        $db = static::getDB();
        $stmt = $db->query('
			SELECT
				`product`.id,
				`product`.name,
				`product`.purchPrice,
				`product`.salesPrice,
				`product`.rentalPrice,
				`product`.discount,
				`product`.description,
				`product`.created,
				`product`.modified,
				COUNT(`item`.id) AS `stock`
			FROM
				`product`
				LEFT JOIN `item` ON `product`.id = `item`.product_id
				GROUP BY `product`.id');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Models\Product', [null, null, null, null, null, null, null]);
        return $stmt->fetchAll();
    }

    public function getStock()
    {
        if (!$this->stock) {
            $db = static::getDB();
            $stmt = $db->prepare('SELECT COUNT(`item`.id) AS stock FROM `item` WHERE `item`.product_id = :id ');
            $stmt->bindParam(':id', $this->id);
            $stmt->setFetchMode(PDO::FETCH_INTO, $this);
            $stmt->execute();
            $stmt->fetch();
        }
        return $this->stock;
    }

    public function getImage($size, $extension)
    {
        return Image::getImageByProduct($this->id, $size, $extension);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPurchPrice()
    {
        return $this->purchPrice;
    }

    public function getSalesPrice()
    {
        return $this->salesPrice;
    }

    public function getRentalPrice()
    {
        return $this->rentalPrice;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDescription_en()
    {
        return $this->description_en;
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