<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;


class ProductComparator
{
    /**
     * @var Product
     */
    private $product;
    
    
    /**
     * ProductComparator constructor.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    
    
    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }
    
    
    /**
     * Checks if passed product is the same instance
     *
     * @param Product $product
     *
     * @return bool
     */
    public function isSame(Product $product)
    {
        return $this->getProduct() === $product;
    }


    /**
     * Checks if the provided product has the same number.
     *
     * @param Product $product
     * @return bool
     */
    public function hasSameNumber(Product $product): bool
    {
        return $this->getProduct()->getNumber() === $product->getNumber();
    }
}