<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;

use InvalidArgumentException;

class Cart implements CartInterface
{
    /**
     * Each `Product` is managed within its own `ProductGroup`. If there is no group for the `Product`, a new
     * `ProductGroup` will be created.
     *
     * @var ProductGroup[]
     */
    private $arrProductGroups = [];


    /**
     * Checks if the provided $product is within the $group.
     *
     * @param ProductGroup $group
     * @param Product $product
     * @return bool
     */
    private function isProductInProductGroup(ProductGroup $group, Product $product): bool
    {
        if ($group->getProductCount($product) > 0) {
            return true;
        }

        return false;
    }

    
    /**
     * Returns all products currently in the card (Each item is grouped in a `ProductGroup`).
     *
     * @return ProductGroup[]
     */
    public function getItem_List(): array
    {
        return $this->arrProductGroups;
    }


    /**
     * Returns the total price of the cart.
     *
     * @return PriceItem
     */
    public function getGrandTotal(): PriceItem
    {
        // Create empty price item object, which is later on filled with the data
        $priceSum = new PriceItem(0.0);

        // Summarize each product group
        foreach ($this->getItem_List() as $productGroup) {
            $priceSum->addPrice($productGroup->getPrice());
        }

        return $priceSum;
    }


    /**
     * Add a specified $product for $count times into the cart.
     *
     * @param Product $product
     * @param int $count
     * @return CartInterface
     *
     * @throws InvalidArgumentException
     */
    public function addProduct(Product $product, int $count = 1): CartInterface
    {
        if ($count < 1) {
            throw new InvalidArgumentException(sprintf("[%i] is not a valid count.", $count));
        }

        // Check if $product can be found in the list
        foreach ($this->getItem_List() as $productGroup) {
            // If the $product was found, insert the items for $count times
            if ($this->isProductInProductGroup($productGroup, $product)) {
                for ($i = 0; $i < $count; $i++) {
                    $productGroup->addProduct($product);
                }
                return $this;
            }
        }

        // If $product was not found in the list we create a new `ProductGroup` entry, which will be inserted into the list
        $insertProductGroup = new ProductGroup();
        // Insert products based on the count
        for ($i = 0; $i < $count; $i++) {
            $insertProductGroup->addProduct($product);
        }
        // Add product group to array
        $this->arrProductGroups[] = $insertProductGroup;

        return $this;
    }


    /**
     * Remove a specified $product for $count times from the cart.
     *
     * @param Product $product
     * @param int $count
     * @return CartInterface
     *
     * @throws InvalidArgumentException
     */
    public function removeProduct(Product $product, int $count = 1): CartInterface
    {
        if ($count < 1) {
            throw new InvalidArgumentException(sprintf("[%i] is not a valid count.", $count));
        }

        // Iterate over the item-list and check if the $product is found within $productGroup
        foreach ($this->getItem_List() as $productGroup) {
            // If the $product is found in the $productGroup remove it for $count amount of times
            if ($this->isProductInProductGroup($productGroup, $product)) {
                $productGroup->removeProducts_with_Number($product->getNumber(), $count);
            }
        }

        return $this;
    }
}