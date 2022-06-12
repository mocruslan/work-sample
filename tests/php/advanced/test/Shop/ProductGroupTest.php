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


    public function getProductCount(): \Generator
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
     * @testdox Tests removeProduct() method with multiple data inputs and compares the result with the expected array.
     *
     * @group unit
     *
     * @covers \NiceshopsDev\NiceAcademy\Tests\Advanced\Shop\ProductGroup::removeProduct
     *
     * @dataProvider removeProductProvider
     *
     * @param Product[] $arrProduct
     * @param Product $productToRemove
     * @param Product[] $arrExpectedResults
     */
    public function testRemoveProduct(array $arrProduct, Product $productToRemove, array $arrExpectedResults)
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
     * @testdox Tests getProductCount() method with multiple data inputs and compares the result with the expected array.
     *
     * @group unit
     *
     * @covers \NiceshopsDev\NiceAcademy\Tests\Advanced\Shop\ProductGroup::getProductCount
     *
     * @dataProvider getProductCount
     *
     * @param Product[] $arrProduct
     * @param Product $productToSearch
     * @param int $expectedCount
     */
    public function testGetProductCount(array $arrProduct, Product $productToSearch, int $expectedCount)
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
}
