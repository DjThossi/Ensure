<?php
namespace Unit\DjThossi\Ensure;

use DjThossi\Ensure\EnsureIsBooleanTrait;
use DjThossi\Ensure\InvalidValueException;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * @covers \DjThossi\Ensure\EnsureIsBooleanTrait
 */
class EnsureIsBooleanTraitTest extends PHPUnit_Framework_TestCase
{
    use EnsureIsBooleanTrait;

    /**
     * @dataProvider workingValuesProvider
     *
     * @param string $fieldName
     * @param mixed $value
     */
    public function testEnsureIsWorking($fieldName, $value)
    {
        $this->ensureIsBoolean($fieldName, $value);
        $this->assertTrue(true, 'This test should get here');
    }

    /**
     * @return array
     */
    public function workingValuesProvider()
    {
        return [
            'True' => ['FieldNameTrue', true],
            'False' => ['FieldNameFalse', false],
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

        $this->ensureIsBoolean($fieldName, $value, $exceptionCode);
    }

    /**
     * @return array
     */
    public function failingValuesProvider()
    {
        return [
            'String' => ['FieldName', 'Hello World', 1, 'FieldName is not a boolean, got "string"'],
            'Double' => ['FieldName', 1.337, 2, 'FieldName is not a boolean, got "double"'],
            'Integer' => ['FieldName', 1337, 3, 'FieldName is not a boolean, got "integer"'],
            'object' => ['FieldName', new stdClass(), 4, 'FieldName is not a boolean, got "stdClass"'],
            'empty' => ['FieldName', '', 5, 'FieldName is not a boolean, got "string"'],
            'null' => ['FieldName', null, 5, 'FieldName is not a boolean, got "NULL"'],
        ];
    }
}
