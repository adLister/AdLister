<?php
// class InvalidArgumentException extends Exception { }
// class OutOfRangeException extends InvalidArgumentException { }
// class DomainException extends OutOfRangeException { }
// class LengthException extends DomainException { }
// class RangeException extends LengthException { }

class Input
{
    /**
     * Check if a given value was passed in the request
     *
     * @param string $key index to look for in request
     * @return boolean whether value exists in $_POST or $_GET
     */
    public static function has($key)
    {
        if(isset($_REQUEST[$key])){
            return true;
        } else{
            return false;
        }
    }

    /**
     * Get a requested value from either $_POST or $_GET
     *
     * @param string $key index to look for in index
     * @param mixed $default default value to return if key not found
     * @return mixed value passed in request
     */
    public static function get($key, $default = null)
    {
        if (self::has($key)){
            return $_REQUEST[$key];
        } else{
            return null;
        }
    }

    // These methods should use the get() method internally to retrieve the value from $_POST or $_GET.
    // If the values does not exist, or match the expected type, throw an exception
    public static function getString($key, $min = 1, $max = 500)
    {
        $value = trim(static::get($key));

        if (empty($key)) {
            throw new OutOfRangeException("$key is a required field!"); 
        }

        if (!is_string($value) || is_numeric($value)) {
            throw new DomainException("$key must be a string!");
        }

        if (!isset($value) || is_numeric($value)){
            throw new InvalidArgumentException("$key must be a string!"); 
        }

        if (strlen($value) < $min) {
            throw new LengthException("$key is too short!");
        } else if (strlen($value) > $max) {
            throw new LengthException("$key is too long!");
        }

        return $value;
    }

    public static function getNumber($key, $min = 1, $max = 9999999999999)
    {
        $value = trim(str_replace(',', '', static::get($key)));

        if (empty($key)) {
            throw new OutOfRangeException("$key is a required field!");
        }

        if (!is_numeric($min) || !is_numeric($max)) {
            throw new InvalidArgumentException("$key must be numeric!");
        }

        if (!is_numeric($value)) {
            throw new DomainException("$key must be numeric!");
        }

        if ($value < $min) {
            throw new RangeException("$key is too small!");
        } else if ($value > $max) {
            throw new RangeException("$key is too big!");
        }

        return $value;
    }

    // public static function getDate($key)
    // {
    //     $value = static::get($key);
    //     $format = 'Y-m-d';

    //     $dateObject = DateTime::createFromFormat($format, $value);

    //     if ($dateObject) {
    //         return $dateObject->date;
    //     } else {
    //         throw new Exception('This must be a valid date');
    //     }
    // }

    ///////////////////////////////////////////////////////////////////////////
    //                      DO NOT EDIT ANYTHING BELOW!!                     //
    // The Input class should not ever be instantiated, so we prevent the    //
    // constructor method from being called. We will be covering private     //
    // later in the curriculum.                                              //
    ///////////////////////////////////////////////////////////////////////////
    private function __construct() {}
}