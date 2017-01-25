<?php
namespace Unit\DjThossi\Ensure;

use DjThossi\Ensure\EnsureMatchesPatternTrait;
use DjThossi\Ensure\InvalidValueException;
use PHPUnit_Framework_TestCase;

/**
 * @covers \DjThossi\Ensure\EnsureMatchesPatternTrait
 */
class EnsureMatchesPatterTraitTest extends PHPUnit_Framework_TestCase
{
    use EnsureMatchesPatternTrait;

    /**
     * @dataProvider workingValuesProvider
     *
     * @param string $fieldName
     * @param string $regex
     * @param string $value
     */
    public function testEnsureIsWorking($fieldName, $regex, $value)
    {
        $this->ensureMatchesPattern($fieldName, $regex, $value);
        $this->assertTrue(true, 'This test should get here');
    }

    /**
     * @return array
     */
    public function workingValuesProvider()
    {
        return [
            'Currency code' => ['code', '/^\b[A-Z]{3}$/', 'EUR'],
            'sku' => ['sku', '/P[\d]{3}_F[\d]{2}_N_D[\d]{2}_V[\d]{2}/', 'P001_F01_N_D00_V00'],
            'id' => ['id', '/^[\d]{3}-[\d]{7}-[\d]{7}$/', '123-1234567-1234567'],
        ];
    }

    /**
     * @dataProvider failingValuesProvider
     *
     * @param string $fieldName
     * @param string $regex
     * @param string $value
     * @param int $exceptionCode
     * @param string $expectedMessage
     */
    public function testEnsureIsFailing($fieldName, $regex, $value, $exceptionCode, $expectedMessage)
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionCode($exceptionCode);
        $this->expectExceptionMessage($expectedMessage);

        $this->ensureMatchesPattern($fieldName, $regex, $value, $exceptionCode);
    }

    /**
     * @return array
     */
    public function failingValuesProvider()
    {
        return [
            'Currency code' => ['code', '/^\b[A-Z]{3}$/', 'EU2', 0, 'code does not match the regular expression '],
            'sku 1' => ['sku', '/P[\d]{3}_F[\d]{2}_N_D[\d]{2}_V[\d]{2}/', 'P001_F01_N_DA0_V00', 0, 'sku does not match the regular expression "/P[\d]{3}_F[\d]{2}_N_D[\d]{2}_V[\d]{2}/", got "P001_F01_N_DA0_V00"'],
            'sku 2' => ['sku', '/P[\d]{3}_F[\d]{2}_N_D[\d]{2}_V[\d]{2}/', 'P0001_F01_N_D00_V00', 0, 'sku does not match the regular expression "/P[\d]{3}_F[\d]{2}_N_D[\d]{2}_V[\d]{2}/", got "P0001_F01_N_D00_V00"'],
            'id 1' => ['id', '/^[\d]{3}-[\d]{7}-[\d]{7}$/', '12A-1234567-1234567', 0, 'id does not match the regular expression "/^[\d]{3}-[\d]{7}-[\d]{7}$/", got "12A-1234567-1234567"'],
            'id 2' => ['id', '/^[\d]{3}-[\d]{7}-[\d]{7}$/', '123-1234567-12345678', 0, 'id does not match the regular expression "/^[\d]{3}-[\d]{7}-[\d]{7}$/", got "123-1234567-12345678"'],
        ];
    }
}
