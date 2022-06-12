<?php

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    // region Data providers
    public function cartFunctionalityProvider(): \Generator
    {
        $product_A = new Product("1", "Produkt A", 10.00);
        $product_B = new Product("2", "Produkt B", 15.00);
        $product_C = new Product("3", "Produkt C", 20.00);

        yield 'insert product A x3, B x2 and C x1. remove product B x1' => [
            [
                [$product_A, 3],
                [$product_B, 2],
                [$product_C, 1],
            ],
            array(1 => $product_B),
            65.0
        ];

        yield 'insert product A x2, B x3 and C x1. remove none' => [
            [
                [$product_A, 2],
                [$product_B, 3],
                [$product_C, 1],
            ],
            [],
            85.0
        ];

        yield 'insert product A x3, B x2 and C x1. remove product A x2' => [
            [
                [$product_A, 3],
                [$product_B, 2],
                [$product_C, 1],
            ],
            array(2 => $product_A),
            60.0
        ];

        yield 'no products inserted. remove product A x2' => [
            [],
            array(2 => $product_A),
            0.0
        ];

        yield 'no products inserted. remove none' => [
            [],
            [],
            0.0
        ];
    }
    // endregion


    /**
     * @var Cart|MockObject
     */
    protected $object;


    protected function setUp()
    {
        $this->object = $this->getMockBuilder(Cart::class)->disableOriginalConstructor()->getMockForAbstractClass();
    }


    /**
     * @testdox Test the general functionality of the `Cart` class.
     *
     * @group integration
     *
     * @dataProvider cartFunctionalityProvider
     *
     * @param array $arrInsert
     * @param array $removeItem
     * @param float $expectedSum
     */
    public function testCartFunctionality(array $arrInsert, array $removeItem, float $expectedSum)
    {
        // Add products x times to the cart
        foreach ($arrInsert as list($product, $count)) {
            $this->object->addProduct($product, $count);
        }

        // Remove specific product x times
        foreach ($removeItem as $count => $product) {
            $this->object->removeProduct($product, $count);
        }

        // Retrieve grand total sum
        $resultGrandTotalSum = $this->object->getGrandTotal()->getPrice();

        $this->assertEquals($expectedSum, $resultGrandTotalSum);
    }
}
