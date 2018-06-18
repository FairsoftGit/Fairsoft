<?php
/**
 * Created by PhpStorm.
 * User: SightVision
 * Date: 18-6-2018
 * Time: 20:27
 */

namespace App\Models;

use PHPUnit\Framework\TestCase;
class ProductTest extends TestCase
{

	public function testGetProductId()
	{
		$id = 1;
		$product = Product::constructFromDatabase($id);
		$result = $product->getProductId();

		$this->assertEquals(1, $result);
	}

	public function testGetThumbSize()
	{
		$id = 1;
		$product = Product::constructFromDatabase($id);
		$result = $product->getThumbSize();

		$this->assertEquals(60, $result);
	}

	public function testGetsalesPrice()
	{
		$id = 2;
		$product = Product::constructFromDatabase($id);
		$result = $product->getSalesPrice();

		$this->assertEquals(99.99, $result);
	}

	public function testGetImgSize()
	{
		$id = 2;
		$product = Product::constructFromDatabase($id);
		$result = $product->getImgSize();

		$this->assertEquals(849, $result);
	}

	public function testGetImgUrl()
	{
		$id = 3;
		$product = Product::constructFromDatabase($id);
		$result = $product->getImgUrl();

		$this->assertEquals("../img/fairGoggles-pic.png", $result);
	}

	public function testGetProductDesc()
	{
		$id = 3;
		$product = Product::constructFromDatabase($id);
		$result = $product->getProductDesc();

		$this->assertEquals("<p>Bij airsoft is het altijd verplicht om oogbescherming te dragen.</p><p>Hiervoor hebben wij onze eigen Fair Goggles geïntroduceerd.</p><p>Dit is ‘geavanceerde’ oogbescherming, waar een camera in zit zodat een speler zijn spel op kan nemen.</p><p>Ook kunnen de beelden live gestreamd worden naar een server, zodat mensen live een wedstrijd kunnen volgen. De FairGoggles maakt via een WiFi signaal verbinding met de FairBox.</p>", $result);
	}

	public function testGetProductName()
	{
		$id = 4;
		$product = Product::constructFromDatabase($id);
		$result = $product->getProductName();

		$this->assertEquals("FairApp", $result);
	}

	public function testGetProductDesc_en()
	{
		$id = 4;
		$product = Product::constructFromDatabase($id);
		$result = $product->getProductDesc_en();

		$this->assertEquals("<p>Download here our FairApp</p>", $result);
	}
}
