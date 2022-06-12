<?php

namespace NiceshopsDev\NiceAcademy\Tests\Basic;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionMethod;

class NiceClassTest extends TestCase
{
    // region Data providers
    public function resultDataProvider(): array
    {
        return [
            ["be nice"],
        ];
    }
    // endregion


    /**
     * @var NiceClass|MockObject
     */
    protected $object;
    
    
    protected function setUp()
    {
        $this->object = $this->getMockBuilder(NiceClass::class)->disableOriginalConstructor()->getMockForAbstractClass();
    }
    
    
    /**
     * @group  integration
     * @small
     */
    public function testTestClassExists()
    {
        $this->assertTrue(class_exists(NiceClass::class));
        $this->assertTrue($this->object instanceof NiceClass);
    }


    /**
     * @testdox Checks for expected return string.
     * @group unit
     * 
     * @throws ReflectionException
     */
    public function testGetString()
    {
        // Given
        $expected = "be ";
        // Since getString() is private we have to use reflection in order to validate the functionality of the unit-test
        $getStringMethod = new ReflectionMethod($this->object, "getString");
        $getStringMethod->setAccessible(true);

        // When
        $result = $getStringMethod->invoke($this->object);

        // Then
        $this->assertSame($expected, $result, "getString() returned unexpected string: " . $result);
    }


    /**
     * @testdox Compares the result string.
     * @group unit
     *
     * @dataProvider resultDataProvider
     */
    public function testResult($dataProvider)
    {
        // When
        $result = $this->object->result();

        // Then
        $this->assertSame($dataProvider, $result, "result() returned unexpected string: " . $result);
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