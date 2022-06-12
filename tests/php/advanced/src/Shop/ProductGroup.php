<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;


class ProductGroup
{
    /**
     * @var Product[]
     */
    private $arrProduct = [];
    
    
    /**
     * @param Product $product
     *
     * @return ProductGroup
     */
    public function addProduct(Product $product): self
    {
        $this->arrProduct[] = $product;
        
        return $this;
    }
    
    
    /**
     * Removes the provided product from the list if it's found.
     *
     * @param Product $product
     *
     * @return $this
     */
    public function removeProduct(Product $product): self
    {
        // Remove the product from the list if it matches any case
        $this->arrProduct = array_diff($this->getProduct_List(), [$product]);
        
        return $this;
    }
    
    
    /**
     * Returns the occurrences of the provided product.
     *
     * @param Product $product
     *
     * @return int
     */
    public function getProductCount(Product $product): int
    {
        // Initialize ProductComparator since it's needed multiple times in the following case
        $comparator = new ProductComparator($product);

        $count = 0;
        foreach ($this->getProduct_List() as $productInList) {
            // Check if the products match (have the same instance)
            if ($comparator->isSame($productInList)) {
                ++$count;
            }
        }
        
        return $count;
    }
    
    
    /**
     * @return int
     */
    public function getCount(): int
    {
        return count($this->getProduct_List());
    }
    
    
    /**
     * Remove $maxCount amount of products with the passed product number.
     *
     * @param string   $number
     * @param int|null $maxCount NULL means no limit (all products with defined number)
     *
     * @todo implement method
     * @return array    list of removed products
     */
    public function removeProducts_with_Number(string $number, int $maxCount = null)
    {
        return [];
    }
    
    
    /**
     * @return Product[]
     */
    public function getProduct_List(): array
    {
        return $this->arrProduct;
    }
}