<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;


class Product
{
    /**
     * @var string
     */
    private $number = "";
    
    
    /**
     * @var string
     */
    private $title = "";


    /**
     * @var PriceItem
     */
    private $price = 0.0;


    /**
     * Product constructor.
     *
     * @param string $number
     * @param string $title
     * @param float $price
     */
    public function __construct(string $number, string $title, float $price)
    {
        $this->number = $number;
        $this->title = $title;
        $this->price = new PriceItem($price);
    }
    
    
    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }
    
    
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price->getPrice();
    }
    
    
    /**
     * Checks if the provided product has the same number.
     *
     * @param Product $product
     *
     * @return bool
     */
    public function hasSameNumber(Product $product): bool
    {
        $comparator = new ProductComparator($this);
        return $comparator->hasSameNumber($product);
    }
    
    
    /**
     * Returns a string in the following format:
     *
     * `#<PRODUCT_NUMBER> <PRODUCT_TITLE>, EUR <PRODUCT_PRICE #,##>`
     *
     * @return string
     */
    public function __toString()
    {
        return "#" . $this->getNumber() . " " . $this->getTitle() . ", EUR " . round($this->getPrice(), 2);
    }
}