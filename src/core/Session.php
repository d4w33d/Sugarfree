<?php

namespace Core;

class Session
{

    public static function initialize()
    {
        session_start();
    }

    public static function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function delete($key)
    {
        if (isset($_SESSION[$key]))
        {
            unset($_SESSION[$key]);
        }
    }

    public static function append($key, $value)
    {
        if (!isset($_SESSION[$key]))
        {
            $_SESSION[$key] = array();
        }
        else if (!is_array($_SESSION[$key]))
        {
            $_SESSION[$key] = (array) $_SESSION[$key];
        }
        $_SESSION[$key][] = $value;
    }

}
