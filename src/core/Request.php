<?php

namespace Core;

class Request extends ArrayObject
{

    const PATH_KEY = '__path';

    private $url;

    public function __construct()
    {
        $this->data = array_merge($_GET, $_POST);
        $this->url = '/' . trim($this->get(self::PATH_KEY), '/');
        $this->delete(self::PATH_KEY);
    }

    public function get($key, $default = null)
    {
        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function delete($key)
    {
        if (isset($this->data[$key]))
        {
            unset($this->data[$key]);
        }
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

}
