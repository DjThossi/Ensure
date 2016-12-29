<?php
namespace Unit\DjThossi\Ensure;

use DjThossi\Ensure\EnsureIsNotEmptyTrait;
use DjThossi\Ensure\InvalidValueException;
use PHPUnit_Framework_TestCase;

/**
 * @covers \DjThossi\Ensure\EnsureIsNotEmptyTrait
 */
class EnsureIsNotEmptyTraitTest extends PHPUnit_Framework_TestCase
{
    use EnsureIsNotEmptyTrait;

    /**
     * @dataProvider workingValuesProvider
     *
     * @param string $fieldName
     * @param mixed $value
     */
    public function testEnsureIsWorking($fieldName, $value)
    {
        $this->ensureIsNotEmpty($fieldName, $value);
        $this->assertTrue(true, 'This test should get here');
    }

    /**
     * @return array
     */
    public function workingValuesProvider()
    {
        return [
            '1337' => ['FieldName1337', 1337],
            'Int 0' => ['FieldName0', 0],
            'String 0' => ['FieldName0', '0'],
            '-1337' => ['FieldName-1337', -1337],
            'true' => ['FieldNameTrue', true],
            'false' => ['FieldNameFalse', false],
            'array' => ['FieldNameArray', ['HelloWorld']],
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

        $this->ensureIsNotEmpty($fieldName, $value, $exceptionCode);
    }

    /**
     * @return array
     */
    public function failingValuesProvider()
    {
        return [
            'Empty String' => ['FieldNameEmptyString', '', 1, 'FieldNameEmptyString should not be empty'],
            'Empty Array' => ['FieldNameEmptyArray', [], 2, 'FieldNameEmptyArray should not be empty'],
            'Null' => ['FieldNameNull', null, 3, 'FieldNameNull should not be empty'],
        ];
    }
}
