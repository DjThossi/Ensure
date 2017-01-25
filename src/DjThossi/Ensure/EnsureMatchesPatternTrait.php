<?php
namespace DjThossi\Ensure;

trait EnsureMatchesPatternTrait
{
    /**
     * @param string $fieldName
     * @param string $regex
     * @param string $valueToTest
     * @param int $exceptionCode
     *
     * @throws InvalidValueException
     */
    protected function ensureMatchesPattern($fieldName, $regex, $valueToTest, $exceptionCode = 0)
    {
        if (preg_match($regex, $valueToTest) !== 1) {
            $message = sprintf('%s does not match the regular expression "%s", got "%s"', $fieldName, $regex, $valueToTest);
            throw new InvalidValueException($message, $exceptionCode);
        }
    }
}
