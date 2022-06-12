<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ProductGroupTest extends TestCase
{
    // region Data providers
    public function removeProductProvider(): \Generator
    {
        $product_A = new Product("1", "Produkt A", 10.00);
        $product_B = new Product("2", "Produkt B", 20.00);

        yield 'product list empty. remove product A' => [
            [], $product_A, []
        ];

        yield 'product list has product A and B. remove product A' => [
            [$product_A, $product_B], $product_A, [$product_B]
        ];

        yield 'product list has product A and B. remove product B' => [
            [$product_A, $product_B], $product_B, [$product_A]
        ];

        yield 'product list has product A, B and A. remove product A' => [
            [$product_A, $product_B], $product_A, [$product_B]
        ];
    }


    public function getProductCountProvider(): \Generator
    {
        $product_A = new Product("1", "Produkt A", 10.00);
        $product_B = new Product("2", "Produkt B", 20.00);
        $product_C = new Product("3", "Produkt C", 30.00);

        yield 'product list has no entries. count occurrence of A' => [
            [], $product_A, 0
        ];

        yield 'product list has product A, B and A. count occurrence of A' => [
            [$product_A, $product_B, $product_A], $product_A, 2
        ];

        yield 'product list has product A, B and C. count occurrence of A' => [
            [$product_A, $product_B, $product_C], $product_A, 1
        ];
    }


    public function removeProducts_with_NumberProvider(): \Generator
    {
        $product_A = new Product("1", "Produkt A", 10.00);
        $product_B = new Product("2", "Produkt B", 20.00);
        $product_C = new Product("1", "Produkt C", 30.00);

        yield 'product list has no entries. remove number 1 with no max count' => [
            [], "1", null, []
        ];

        yield 'product list has product A, B and C. remove number 2 with no max count' => [
            [$product_A, $product_B, $product_C], "2", null, [$product_B]
        ];

        yield 'product list has product A, B and C. remove number 1 with no max count' => [
            [$product_A, $product_B, $product_C], "1", null, [$product_A, $product_C]
        ];

        yield 'product list has product A, B and C. remove number 1 with max count 1' => [
            [$product_A, $product_B, $product_C], "1", 1, [$product_A]
        ];
    }


    public function getPriceProvider(): \Generator
    {
        $product_A = new Product("1", "Produkt A", 10.00);
        $product_B = new Product("2", "Produkt B", 20.00);
        $product_C = new Product("3", "Produkt C", 30.00);

        yield 'product list with sum 60' => [
            [$product_A, $product_B, $product_C], 60.0
        ];

        yield 'empty product list with sum 0' => [
            [], 0.0
        ];

        yield 'product list with same product sum 60' => [
            [$product_A, $product_A, $product_A], 30.0
        ];
    }
    // endregion

    /**
     * @var ProductGroup|MockObject
     */
    protected $object;
    
    
    protected function setUp()
    {
        $this->object = $this->getMockBuilder(ProductGroup::class)->disableOriginalConstructor()->getMockForAbstractClass();
    }
    
    
    /**
     * @group  integration
     * @small
     */
    public function testTestClassExists()
    {
        $this->assertTrue(class_exists(ProductGroup::class));
        $this->assertTrue($this->object instanceof ProductGroup);
    }
    
    
    /**
     * @group unit
     * @small
     *
     * @covers \NiceshopsDev\NiceAcademy\Tests\Advanced\Shop\ProductGroup::getCount
     */
    public function testGetCount()
    {
        /**
         * @var ProductGroup|MockObject $productGroup
         */
        $productGroup = $this->getMockBuilder(ProductGroup::class)->disableOriginalConstructor()->setMethods(["getProduct_List"])->getMockForAbstractClass();
        
        $arrProduct_List = [
            "Foo", "Bar", "Baz",
        ];
        
        $productGroup->expects($this->once())->method("getProduct_List")->with()->willReturn($arrProduct_List);
        
        $this->assertSame(3, $productGroup->getCount());
    }


    /**
     * @testdox Tests `removeProduct()` method with multiple data inputs and compares the result with the expected array.
     *
     * @group unit
     *
     * @covers \NiceshopsDev\NiceAcademy\Tests\Advanced\Shop\ProductGroup::removeProduct
     *
     * @dataProvider removeProductProvider
     *
     * @param ProductTypeInterface[] $arrProduct
     * @param ProductTypeInterface $productToRemove
     * @param ProductTypeInterface[] $arrExpectedResults
     */
    public function testRemoveProduct(array $arrProduct, ProductTypeInterface $productToRemove, array $arrExpectedResults)
    {
        // Given
        foreach ($arrProduct as $product) {
            // Insert items into the ProductGroup
            $this->object->addProduct($product);
        }

        // When
        $result = $this->object->removeProduct($productToRemove);

        // Then
        $this->assertEqualsCanonicalizing($arrExpectedResults, $result->getProduct_List(),
            "Unexpected entries in product list!");
    }


    /**
     * @testdox Tests `getProductCount()` method with multiple data inputs and compares the result with the expected array.
     *
     * @group unit
     *
     * @covers \NiceshopsDev\NiceAcademy\Tests\Advanced\Shop\ProductGroup::getProductCount
     *
     * @dataProvider getProductCountProvider
     *
     * @param ProductTypeInterface[] $arrProduct
     * @param ProductTypeInterface $productToSearch
     * @param int $expectedCount
     */
    public function testGetProductCount(array $arrProduct, ProductTypeInterface $productToSearch, int $expectedCount)
    {
        // Given
        $productGroup = $this->getMockBuilder(ProductGroup::class)->disableOriginalConstructor()
            ->setMethods(["getProduct_List"])->getMockForAbstractClass();
        $productGroup->expects($this->once())->method("getProduct_List")->with()->willReturn($arrProduct);

        // When
        $result = $productGroup->getProductCount($productToSearch);

        // Then
        $this->assertSame($expectedCount, $result);
    }


    /**
     * @testdox Tests `removeProducts_with_Number()` method with multiple data inputs and compares the result with the
     * expected array.
     *
     * @group unit
     *
     * @covers \NiceshopsDev\NiceAcademy\Tests\Advanced\Shop\ProductGroup::removeProducts_with_Number
     *
     * @dataProvider removeProducts_with_NumberProvider
     *
     * @param ProductTypeInterface[] $arrProduct
     * @param string $numberToRemove
     * @param int|null $maxCount
     * @param ProductTypeInterface[] $arrExpectedResults
     */
    public function testRemoveProducts_with_Number(array $arrProduct, string $numberToRemove, ?int $maxCount,
                                                   array $arrExpectedResults)
    {
        // Given
        $productGroup = $this->getMockBuilder(ProductGroup::class)->disableOriginalConstructor()
            ->setMethods(["getProduct_List"])->getMockForAbstractClass();
        $productGroup->expects($this->atMost(2))->method("getProduct_List")->with()->willReturn($arrProduct);

        // When
        $arrResult = $productGroup->removeProducts_with_Number($numberToRemove, $maxCount);

        // Then
        $this->assertEqualsCanonicalizing($arrExpectedResults, $arrResult,
            "Unexpected entries in remove result list!");
    }


    /**
     * @testdox Tests the implementation of the `PriceAwareInterface` function `getPrice()`.
     *
     * @group unit
     *
     * @covers \NiceshopsDev\NiceAcademy\Tests\Advanced\Shop\ProductGroup::getPrice
     *
     * @dataProvider getPriceProvider
     *
     * @param ProductTypeInterface[] $arrProduct
     * @param float $expectedPriceSum
     */
    public function testGetPrice(array $arrProduct, float $expectedPriceSum)
    {
        // Given
        $productGroup = $this->getMockBuilder(ProductGroup::class)->disableOriginalConstructor()
            ->setMethods(["getProduct_List"])->getMockForAbstractClass();
        $productGroup->expects($this->once())->method("getProduct_List")->with()->willReturn($arrProduct);

        // When
        $resultSumPrice = $productGroup->getPrice()->getPrice();

        // Then
        $this->assertSame($expectedPriceSum, $resultSumPrice);
    }
}
