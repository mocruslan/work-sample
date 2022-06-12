<?php
declare(strict_types=1);

namespace NiceshopsDev\NiceAcademy\Tests\Basic;

use Countable;

class NiceClass implements Countable
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


    /**
     * Returns the number of characters from the `result()` method call.
     *
     * @return int
     */
    public function count(): int
    {
        return strlen($this->result());
    }
}