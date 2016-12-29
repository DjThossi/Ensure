<?php
namespace Unit\DjThossi\Ensure;

use DjThossi\Ensure\EnsureIsIntegerTrait;
use DjThossi\Ensure\InvalidValueException;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * @covers \DjThossi\Ensure\EnsureIsIntegerTrait
 */
class EnsureIsIntegerTraitTest extends PHPUnit_Framework_TestCase
{
    use EnsureIsIntegerTrait;

    /**
     * @dataProvider workingValuesProvider
     *
     * @param string $fieldName
     * @param mixed $value
     */
    public function testEnsureIsWorking($fieldName, $value)
    {
        $this->ensureIsInteger($fieldName, $value);
        $this->assertTrue(true, 'This test should get here');
    }

    /**
     * @return array
     */
    public function workingValuesProvider()
    {
        return [
            '1337' => ['FieldName1337', 1337],
            '0' => ['FieldName0', 0],
            '-1337' => ['FieldName-1337', -1337],
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

        $this->ensureIsInteger($fieldName, $value, $exceptionCode);
    }

    /**
     * @return array
     */
    public function failingValuesProvider()
    {
        return [
            'String' => ['FieldName', 'Hello World', 1, 'FieldName is not an integer, got "string"'],
            'Double' => ['FieldName', 1.337, 2, 'FieldName is not an integer, got "double"'],
            'True' => ['FieldName', true, 3, 'FieldName is not an integer, got "boolean"'],
            'False' => ['FieldName', false, 4, 'FieldName is not an integer, got "boolean"'],
            'object' => ['FieldName', new stdClass(), 5, 'FieldName is not an integer, got "stdClass"'],
            'empty' => ['FieldName', '', 6, 'FieldName is not an integer, got "string"'],
            'null' => ['FieldName', null, 7, 'FieldName is not an integer, got "NULL"'],
        ];
    }
}
