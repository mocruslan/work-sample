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
     * @param Product $product
     *
     * @return bool
     */
    public function hasSameNumber(Product $product): bool
    {
        return $this->getNumber() === $product->getNumber();
    }
    
    
    /**
     * @return string
     */
    public function __toString()
    {
        return "#" . $this->getNumber() . " " . $this->getTitle();
    }
}