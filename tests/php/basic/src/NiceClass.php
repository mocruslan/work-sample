<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Basic;


class NiceClass
{
    /**
     * Returns the string "be ".
     *
     * @return string
     */
    public function getString(): string
    {
        return "be ";
    }
    
    
    /**
     * Returns the string "be nice".
     *
     * @return string
     */
    public function result(): string
    {
        return trim($this->getString()) . " nice";
    }
}