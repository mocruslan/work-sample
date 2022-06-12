<?php

namespace NiceshopsDev\NiceAcademy\Tests\Basic;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

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
     */
    public function testGetString()
    {
        // Given
        $expected = "be ";

        // When
        $result = $this->object->getString();

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
}
