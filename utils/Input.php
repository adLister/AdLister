<?php

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
    public function getString($key)
    {
        $value = static::get($key);

        if (!isset($value) {
            throw new Exception('{$key} is a required field!'); 
        }

        if (!is_string($value) {
            throw new Exception('{$key} must be a string!'); 
        }

        $this->key = trim($key);
    }

    public function getNumber($key)
    {
        $value = static::get($key);

        if (!isset($value) {
            throw new Exception('{$key} is a required field!');
        }

        if (!is_numeric($value) {
            throw new Exception('{$key} must be numeric!');
        }

        $this->key = trim($key);
    }

    ///////////////////////////////////////////////////////////////////////////
    //                      DO NOT EDIT ANYTHING BELOW!!                     //
    // The Input class should not ever be instantiated, so we prevent the    //
    // constructor method from being called. We will be covering private     //
    // later in the curriculum.                                              //
    ///////////////////////////////////////////////////////////////////////////
    private function __construct() {}
}