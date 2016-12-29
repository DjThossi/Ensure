<?php
namespace Unit\DjThossi\Ensure;

use DjThossi\Ensure\EnsureIsUrlTrait;
use DjThossi\Ensure\InvalidValueException;
use PHPUnit_Framework_TestCase;

/**
 * @covers \DjThossi\Ensure\EnsureIsUrlTrait
 */
class EnsureIsUrlTraitTest extends PHPUnit_Framework_TestCase
{
    use EnsureIsUrlTrait;

    /**
     * @dataProvider workingValuesProvider
     *
     * @param string $fieldName
     * @param string $value
     */
    public function testEnsureIsWorking($fieldName, $value)
    {
        $this->ensureIsUrl($fieldName, $value);
        $this->assertTrue(true, 'This test should get here');
    }

    /**
     * @return array
     */
    public function workingValuesProvider()
    {
        return [
            'My Domain' => ['FieldName', 'http://www.sebastianthoss.de'],
            'My Website' => ['FieldName', 'http://www.sebastianthoss.de/en/talks.html'],
            'FTP' => ['FieldName', 'ftp://www.example.com'],
        ];
    }

    /**
     * @dataProvider failingValuesProvider
     *
     * @param string $fieldName
     * @param string $value
     * @param int $exceptionCode
     * @param string $expectedMessage
     */
    public function testEnsureIsFailing($fieldName, $value, $exceptionCode, $expectedMessage)
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionCode($exceptionCode);
        $this->expectExceptionMessage($expectedMessage);

        $this->ensureIsUrl($fieldName, $value, $exceptionCode);
    }

    /**
     * @return array
     */
    public function failingValuesProvider()
    {
        return [
            'String' => ['FieldName', 'Hello World', 1, 'FieldName is not a matching url, got "Hello World"'],
            'empty' => ['FieldName', '', 2, 'FieldName is not a matching url, got ""'],
            'brokenUrl' => [
                'FieldName',
                'ttp://www.ex.com',
                3,
                'FieldName is not a matching url, got "ttp://www.ex.com"',
            ],
        ];
    }
}
