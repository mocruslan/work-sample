<?php

namespace NiceshopsDev\NiceAcademy\Tests\Basic;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MyNiceClassTest extends TestCase
{
    /**
     * @var MyNiceClass|MockObject
     */
    protected $object;


    protected function setUp()
    {
        $this->object = $this->getMockBuilder(MyNiceClass::class)->disableOriginalConstructor()->getMockForAbstractClass();
    }


    /**
     * @group  integration
     * @small
     */
    public function testTestClassExists()
    {
        $this->assertTrue(class_exists(MyNiceClass::class));
        $this->assertTrue($this->object instanceof MyNiceClass);
    }


    /**
     * @testdox Compares the result string.
     * @group unit
     */
    public function testResult()
    {
        // Given
        $expect = "always be nice";

        // When
        $result = $this->object->result();

        // Then
        $this->assertSame($expect, $result, "result() returned unexpected result: " . $result);
    }


    /**
     * @testdox Checks if the count returned the expected amount.
     * @group unit
     */
    public function testCount()
    {
        // Given
        $expected = 7;

        // When
        $result = $this->object->count();

        // Then
        $this->assertSame($expected, $result, "count() returned unexpected number: " . $result);
    }
}
