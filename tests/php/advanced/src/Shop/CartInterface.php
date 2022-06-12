<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;


interface CartInterface
{
    /**
     * @return PriceItem
     */
    public function getGrandTotal(): PriceItem;
    
    
    /**
     * @param ProductTypeInterface $product
     * @param int     $count
     *
     * @return $this
     */
    public function addProduct(ProductTypeInterface $product, int $count = 1): self;
    
    
    /**
     * @param ProductTypeInterface $product
     * @param int     $count
     *
     * @return $this
     */
    public function removeProduct(ProductTypeInterface $product, int $count = 1): self;
}