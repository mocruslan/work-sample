<?php

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;

interface ProductTypeInterface
{
    /**
     * @return string
     */
    public function getNumber(): string;


    /**
     * @return string
     */
    public function getTitle(): string;


    /**
     * @return PriceItem
     */
    public function getPrice(): PriceItem;
}