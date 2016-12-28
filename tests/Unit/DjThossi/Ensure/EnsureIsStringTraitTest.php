<?php
namespace Unit\DjThossi\Ensure;

use DjThossi\Ensure\EnsureIsStringTrait;
use DjThossi\Ensure\InvalidValueException;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * @covers \DjThossi\Ensure\EnsureIsStringTrait
 */
class EnsureIsStringTraitTest extends PHPUnit_Framework_TestCase
{
    use EnsureIsStringTrait;

    /**
     * @dataProvider workingValuesProvider
     *
     * @param string $fieldName
     * @param mixed $value
     */
    public function testEnsureIsWorking($fieldName, $value)
    {
        $this->ensureIsString($fieldName, $value);
        $this->assertTrue(true, 'This test should get here');
    }

    /**
     * @return array
     */
    public function workingValuesProvider()
    {
        return [
            'Empty' => ['FieldName', ''],
            'Short' => ['FieldName', 'HelloWorld'],
        ];
    }

    /**
     * @dataProvider failingValuesProvider
     *
     * @param string $fieldName
     * @param mixed $value
     * @param int $exceptionCode
     * @param string $expectedMessage
     */
    public function testEnsureIsFailing($fieldName, $value, $exceptionCode, $expectedMessage)
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionCode($exceptionCode);
        $this->expectExceptionMessage($expectedMessage);

        $this->ensureIsString($fieldName, $value, $exceptionCode);
    }

    /**
     * @return array
     */
    public function failingValuesProvider()
    {
        return [
            'True' => ['FieldName', true, 1, 'FieldName is not a string, got "boolean"'],
            'False' => ['FieldName', true, 2, 'FieldName is not a string, got "boolean"'],
            'Double' => ['FieldName', 1.337, 3, 'FieldName is not a string, got "double"'],
            'Integer' => ['FieldName', 1337, 4, 'FieldName is not a string, got "integer"'],
            'object' => ['FieldName', new stdClass(), 5, 'FieldName is not a string, got "stdClass"'],
        ];
    }
}
