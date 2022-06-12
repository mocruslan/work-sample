<?php

namespace NiceshopsDev\NiceAcademy\Tests\Advanced\Shop;

interface PriceAwareInterface
{
    /**
     * @return PriceItem
     */
    public function getPrice(): PriceItem;
}