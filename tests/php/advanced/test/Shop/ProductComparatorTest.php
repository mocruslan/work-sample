<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ProductComparatorTest extends TestCase
{
    
    
    /**
     * @var ProductComparator|MockObject
     */
    protected $object;
    
    
    protected function setUp()
    {
        // Currently the getProduct() method is mocked
        $this->object = $this->getMockBuilder(ProductComparator::class)->disableOriginalConstructor()
            ->setMethods(["getProduct"])->getMockForAbstractClass();
    }
    
    
    /**
     * @group  integration
     * @small
     */
    public function testTestClassExists()
    {
        $this->assertTrue(class_exists(ProductComparator::class));
        $this->assertTrue($this->object instanceof ProductComparator);
    }


    /**
     * @testdox Checks if the number of the products matches.
     * @group unit
     *
     * @covers \NiceshopsDev\NiceAcademy\Tests\Advanced\Shop\ProductComparator::hasSameNumber
     */
    public function testHasSameNumber()
    {
        // Given
        $sameProduct = new Product("2", "AnotherNiceSite", 40.02);
        $differentProduct = new Product("3", "YetAnotherNiceSite", 40.50);
        $this->object->expects($this->exactly(2))->method("getProduct")->willReturn(
            new Product("2", "ActualNiceSite", 63.20)
        );

        // When
        $resultEquals = $this->object->hasSameNumber($sameProduct);
        $resultDifferent = $this->object->hasSameNumber($differentProduct);

        // Then
        $this->assertTrue($resultEquals);
        $this->assertFalse($resultDifferent);
    }
}
