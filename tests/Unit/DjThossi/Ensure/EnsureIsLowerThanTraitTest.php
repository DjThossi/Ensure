<?php
namespace Unit\DjThossi\Ensure;

use DjThossi\Ensure\EnsureIsLowerThanTrait;
use DjThossi\Ensure\InvalidValueException;
use PHPUnit_Framework_TestCase;

/**
 * @covers \DjThossi\Ensure\EnsureIsLowerThanTrait
 */
class EnsureIsLowerThanTraitTest extends PHPUnit_Framework_TestCase
{
    use EnsureIsLowerThanTrait;

    /**
     * @dataProvider workingValuesProvider
     *
     * @param string $fieldName
     * @param int $maxValue
     * @param int $value
     */
    public function testEnsureIsWorking($fieldName, $maxValue, $value)
    {
        $this->ensureIsLowerThan($fieldName, $maxValue, $value);
        $this->assertTrue(true, 'This test should get here');
    }

    /**
     * @return array
     */
    public function workingValuesProvider()
    {
        return [
            '1337' => ['FieldName1337', 1338, 1337],
            '0' => ['FieldName0', 1, 0],
            '-1' => ['FieldName0', 0, -1],
            '-1337' => ['FieldName-1337', -1336, -1337],
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

        $this->ensureIsLowerThan($fieldName, $maxValue, $value, $exceptionCode);
    }

    /**
     * @return array
     */
    public function failingValuesProvider()
    {
        return [
            'Lower' => ['FieldName', 1335, 1336, 1, 'FieldName is greater than or equal expected value "1335"'],
            'Equal' => ['FieldName', 1337, 1337, 2, 'FieldName is greater than or equal expected value "1337"'],
        ];
    }
}
