<?php
namespace Core;

class Session
{
    /**
     * get a session value
     *
     * @param string $key the key of the wanted value
     * @param string $default the default value to return if not set
     * @return string           the wanted value, or null
     *
     * Static because there is no need to instantiate this method.
     */
    public static function get($key, $default = null)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return $default;
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function clear() {
        session_destroy();
    }
}