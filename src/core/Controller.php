<?php

namespace Core;

use Closure,
    DirectoryIterator;

class Controller
{

    public static function loadAndDispatch($directory)
    {
        $ctrl = new Controller();
        $ctrl->loadHandlers($directory);
        if ($response = $ctrl->dispatch(new Request())) {
            $response->output();
        }
    }

    private $handlers = array();

    public function loadHandlers($directory)
    {
        $it = new DirectoryIterator($directory);
        foreach ($it as $f)
        {
            $path = $f->getPath() . DS . $f;
            if (substr($path, -4) !== '.php')
            {
                continue;
            }
            require $path;
        }
    }

    public function dispatch(Request $request)
    {
        foreach ($this->handlers as $handler)
        {
            list($match, $data) = $handler->compute($request->getUrl());
            if ($match)
            {
                $request->merge($data);
                return $handler->execute($request);
            }
        }
    }

    public function attachHandler($pattern, Closure $closure)
    {
        $this->handlers[] = new ControllerHandler($pattern, $closure);
    }

    public function output($response)
    {
        echo $response;
    }

}

class ControllerHandler
{

    public $pattern;
    public $closure;

    public function __construct($pattern, Closure $closure)
    {
        $this->pattern = $pattern;
        $this->closure = $closure;
    }

    public function compute($url)
    {
        $pattern = '#^' . $this->pattern . '$#';
        if (!preg_match($pattern, $url, $matches))
        {
            return array(false, array());
        }
        foreach ($matches as $key => $value)
        {
            if (is_numeric($key))
            {
                unset($matches[$key]);
            }
        }
        return array(true, $matches);
    }

    public function execute(Request $request)
    {
        $closure = $this->closure;
        return $closure($request, new Response());
    }

}
