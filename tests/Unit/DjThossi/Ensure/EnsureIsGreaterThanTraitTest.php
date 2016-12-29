<?php
namespace Unit\DjThossi\Ensure;

use DjThossi\Ensure\EnsureIsGreaterThanTrait;
use DjThossi\Ensure\InvalidValueException;
use PHPUnit_Framework_TestCase;

/**
 * @covers \DjThossi\Ensure\EnsureIsGreaterThanTrait
 */
class EnsureIsGreaterThanTraitTest extends PHPUnit_Framework_TestCase
{
    use EnsureIsGreaterThanTrait;

    /**
     * @dataProvider workingValuesProvider
     *
     * @param string $fieldName
     * @param int $maxValue
     * @param int $value
     */
    public function testEnsureIsWorking($fieldName, $maxValue, $value)
    {
        $this->ensureIsGreaterThan($fieldName, $maxValue, $value);
        $this->assertTrue(true, 'This test should get here');
    }

    /**
     * @return array
     */
    public function workingValuesProvider()
    {
        return [
            '1337' => ['FieldName1337', 1336, 1337],
            '0' => ['FieldName0', 0, 1],
            '-1' => ['FieldName0', -1, 0],
            '-1337' => ['FieldName-1337', -1338, -1337],
        ];
    }

    /**
     * @dataProvider failingValuesProvider
     *
     * @param string $fieldName
     * @param int $maxValue
     * @param int $value
     * @param int $exceptionCode
     * @param string $expectedMessage
     */
    public function testEnsureIsFailing($fieldName, $maxValue, $value, $exceptionCode, $expectedMessage)
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionCode($exceptionCode);
        $this->expectExceptionMessage($expectedMessage);

        $this->ensureIsGreaterThan($fieldName, $maxValue, $value, $exceptionCode);
    }

    /**
     * @return array
     */
    public function failingValuesProvider()
    {
        return [
            'Lower' => ['FieldName', 1337, 1336, 1, 'FieldName is lower than or equal expected value "1337"'],
            'Equal' => ['FieldName', 1337, 1337, 2, 'FieldName is lower than or equal expected value "1337"'],
        ];
    }
}
