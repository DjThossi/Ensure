<?php
namespace Unit\DjThossi\Ensure;

use DjThossi\Ensure\EnsureIsUrlTrait;
use DjThossi\Ensure\InvalidValueException;
use PHPUnit_Framework_TestCase;
use stdClass;

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
     * @param mixed $value
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
     * @param mixed $value
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
            'Double' => ['FieldName', 1.337, 2, 'FieldName is not a string, got "double"'],
            'Integer' => ['FieldName', 1337, 3, 'FieldName is not a string, got "integer"'],
            'object' => ['FieldName', new stdClass(), 4, 'FieldName is not a string, got "stdClass"'],
            'empty' => ['FieldName', '', 5, 'FieldName is not a matching url, got ""'],
            'null' => ['FieldName', null, 6, 'FieldName is not a string, got "NULL"'],
            'brokenUrl' => [
                'FieldName',
                'ttp://www.ex.com',
                7,
                'FieldName is not a matching url, got "ttp://www.ex.com"',
            ],
        ];
    }
}
