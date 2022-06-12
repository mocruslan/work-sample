<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;


class PriceItem
{
    /**
     * @var float
     */
    private $price = 0.0;


    /**
     * PriceItem constructor.
     *
     * @param float $price
     */
    public function __construct(float $price)
    {
        $this->price = $price;
    }


    /**
     * Returns the price of the PriceItem object.
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }


    /**
     * @param float $price
     *
     * @return $this
     */
    public function addPrice_by_Value(float $price): PriceItem
    {
        $this->price += $price;
        
        return $this;
    }
    
    
    /**
     * @param PriceItem $priceItem
     *
     * @return $this
     */
    public function addPrice(PriceItem $priceItem): PriceItem
    {
        $this->price += $priceItem->getPrice();

        return $this;
    }
}