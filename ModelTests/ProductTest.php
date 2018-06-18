<?php
/**
 * Created by PhpStorm.
 * User: SightVision
 * Date: 18-6-2018
 * Time: 20:27
 */

namespace App\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Product;
class ProductTest extends TestCase
{

	public function testGetProductId()
	{
		$id = 1;
		$product = Product::constructFromDatabase($id);
		$result = $product->getProduct();

		$this->assertEquals(1, $id);
	}

//	public function testGetThumbSize()
//	{
//
//	}
//
//	public function testGetsalesPrice()
//	{
//
//	}
//
//	public function testGetImgSize()
//	{
//
//	}
//
//	public function testGetImgUrl()
//	{
//
//	}
//
//	public function testConstructFromDatabase()
//	{
//
//	}
//
//	public function testGetProductDesc()
//	{
//
//	}
//
//	public function testGetProductName()
//	{
//
//	}
//
//	public function testGetProductDesc_en()
//	{
//
//	}
}
