# Ensure
Some PHP Traits for ensuring values
[![Build Status](https://travis-ci.org/DjThossi/Ensure.svg?branch=master)](https://travis-ci.org/DjThossi/Ensure)
[![Coverage Status](https://coveralls.io/repos/github/DjThossi/Ensure/badge.svg?branch=master)](https://coveralls.io/github/DjThossi/Ensure?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/ccaef76a-725e-4b1b-892a-c3dd4570e629/mini.png)](https://insight.sensiolabs.com/projects/ccaef76a-725e-4b1b-892a-c3dd4570e629)
## How it works
The provided Ensure Traits will test if provided `$valueToTest` has expected value. 
- If `$valueToTest` is valid nothing happens
- If `$valueToTest` is invalid `InvalidValueException` is thrown

## Available Ensure Traits
- EnsureIsBooleanTrait
- EnsureIsGreaterThanTrait
- EnsureIsIntegerTrait
- EnsureIsLowerThanTrait
- EnsureIsNotEmptyTrait
- EnsureIsStringTrait
- EnsureIsUrlTrait

## How to install
You have several options to install this package

### Composer
`composer require djthossi/ensure`

### Git
`git clone https://github.com/DjThossi/Ensure.git`

### Download
`https://github.com/DjThossi/Ensure/archive/master.zip`

## Example
```php
class Message
{
    use EnsureIsStringTrait;
    
    const MESSAGE_IS_NOT_A_STRING = 1;
    
    /**
     * @param string $message
     */
    public function __construct($message)
    {
        $this->ensureIsString('Message', $message, self::MESSAGE_IS_NOT_A_STRING);
    }
}
```

