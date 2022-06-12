<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;


class ProductGroup implements PriceAwareInterface
{
    /**
     * @var ProductTypeInterface[]
     */
    private $arrProduct = [];
    
    
    /**
     * @param ProductTypeInterface $product
     *
     * @return ProductGroup
     */
    public function addProduct(ProductTypeInterface $product): self
    {
        $this->arrProduct[] = $product;
        
        return $this;
    }
    
    
    /**
     * Removes the provided product from the list if it's found.
     *
     * @param ProductTypeInterface $product
     *
     * @return $this
     */
    public function removeProduct(ProductTypeInterface $product): self
    {
        // Remove the product from the list if it matches any case
        $this->arrProduct = array_diff($this->getProduct_List(), [$product]);
        
        return $this;
    }
    
    
    /**
     * Returns the occurrences of the provided product.
     *
     * @param ProductTypeInterface $product
     *
     * @return int
     */
    public function getProductCount(ProductTypeInterface $product): int
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
     * @return array    list of removed products
     */
    public function removeProducts_with_Number(string $number, int $maxCount = null): array
    {
        $arrDeletedEntries = [];

        // If not max count was provided, we use the array size as the max count
        if ($maxCount == null) {
            $maxCount = count($this->getProduct_List());
        }

        $deletedEntryCount = 0;
        foreach ($this->getProduct_List() as $index => $productInList) {
            if ($productInList->getNumber() === $number) {
                // If the number matches we copy the entry into the deleted entry array and remove it from the global list
                $arrDeletedEntries[] = $productInList;
                unset($this->arrProduct[$index]);

                ++$deletedEntryCount;
            }

            if ($deletedEntryCount === $maxCount) {
                // Exit the loop if we have deleted the maximum number of products
                break;
            }
        }

        return $arrDeletedEntries;
    }
    
    
    /**
     * @return ProductTypeInterface[]
     */
    public function getProduct_List(): array
    {
        return $this->arrProduct;
    }

    /**
     * Returns the summarized price of the `ProductGroup` in `PriceItem` format.
     *
     * @return PriceItem
     */
    public function getPrice(): PriceItem
    {
        // Create empty price item object, which is later on filled with the data
        $priceItem = new PriceItem(0.0);

        // Add price for each product in the list
        foreach ($this->getProduct_List() as $product) {
            $priceItem->addPrice($product->getPrice());
        }

        return $priceItem;
    }
}