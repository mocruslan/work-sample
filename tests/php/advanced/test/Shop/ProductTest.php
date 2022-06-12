<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @var Product|MockObject
     */
    protected $object;
    
    
    protected function setUp()
    {
        // Currently the getNumber(), getTitle(), getPrice() methods are mocked
        $this->object = $this->getMockBuilder(Product::class)->disableOriginalConstructor()
            ->setMethods(["getNumber", "getTitle", "getPrice"])->getMockForAbstractClass();
    }
    
    
    /**
     * @group  integration
     * @small
     */
    public function testTestClassExists()
    {
        $this->assertTrue(class_exists(Product::class));
        $this->assertTrue($this->object instanceof Product);
    }


    /**
     * @testdox Checks format of string.
     *
     * @group unit
     *
     * @covers \NiceshopsDev\NiceAcademy\Tests\Advanced\Shop\Product::__toString
     */
    public function testToString()
    {
        // Given
        $this->object->expects($this->once())->method("getNumber")->willReturn("2");
        $this->object->expects($this->once())->method("getTitle")->willReturn("NiceSite");
        $this->object->expects($this->once())->method("getPrice")->willReturn(new PriceItem(490.905));
        $expected = "#2 NiceSite, EUR 490.91";

        // When
        $result = $this->object->__toString();

        // Then
        $this->assertSame($expected, $result, "Invalid string format received: " . $result);
    }


    /**
     * @testdox Checks if the number of the products matches.
     *
     * @group unit
     *
     * @covers \NiceshopsDev\NiceAcademy\Tests\Advanced\Shop\Product::hasSameNumber
     */
    public function testHasSameNumber()
    {
        // Given
        $sameProduct = new Product("2", "AnotherNiceSite", 40.02);
        $differentProduct = new Product("3", "YetAnotherNiceSite", 40.02);
        $this->object->expects($this->exactly(2))->method("getNumber")->willReturn("2");

        // When
        $resultEquals = $this->object->hasSameNumber($sameProduct);
        $resultDifferent = $this->object->hasSameNumber($differentProduct);

        // Then
        $this->assertTrue($resultEquals);
        $this->assertFalse($resultDifferent);
    }


    /**
     * @testdox Tests the implementation of the `PriceAwareInterface` function `getPrice()`.
     *
     * @group unit
     *
     * @covers \NiceshopsDev\NiceAcademy\Tests\Advanced\Shop\Product::getPrice
     */
    public function testGetPrice()
    {
        // Given
        $expectedPrice = 40.02;
        $testProduct = new Product("1", "NiceSite", $expectedPrice);

        // When
        $resultPrice = $testProduct->getPrice()->getPrice();

        // Then
        $this->assertEquals($expectedPrice, $resultPrice);
    }
}
