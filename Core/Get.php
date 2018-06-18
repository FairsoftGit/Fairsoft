<?php
namespace Core;

class Get
{
    public function __construct()
    {
    }

    public static function get($key, $filter = FILTER_DEFAULT, $options = null, $default = null) {
        $value = filter_input(INPUT_GET, $key, $filter, $options);
        if($value === FALSE) {
            return $default;
        }
        return $value;
    }
}