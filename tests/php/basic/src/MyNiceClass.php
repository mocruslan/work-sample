<?php

namespace NiceshopsDev\NiceAcademy\Tests\Basic;

class MyNiceClass extends NiceClass
{
    /**
     * Returns the string "always be nice".
     *
     * @return string
     */
    public function result(): string
    {
        return trim("always " . parent::result());
    }
}