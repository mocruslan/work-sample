<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;


class ProductComparator
{
    /**
     * @var ProductTypeInterface
     */
    private $product;
    
    
    /**
     * ProductComparator constructor.
     *
     * @param ProductTypeInterface $product
     */
    public function __construct(ProductTypeInterface $product)
    {
        $this->product = $product;
    }
    
    
    /**
     * @return ProductTypeInterface
     */
    public function getProduct(): ProductTypeInterface
    {
        return $this->product;
    }
    
    
    /**
     * Checks if passed product is the same instance
     *
     * @param ProductTypeInterface $product
     *
     * @return bool
     */
    public function isSame(ProductTypeInterface $product): bool
    {
        return $this->getProduct() === $product;
    }


    /**
     * Checks if the provided product has the same number.
     *
     * @param ProductTypeInterface $product
     * @return bool
     */
    public function hasSameNumber(ProductTypeInterface $product): bool
    {
        return $this->getProduct()->getNumber() === $product->getNumber();
    }
}