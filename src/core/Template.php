<?php

namespace Core;

class Template
{

    private static $templatesDirectory;
    private static $globalVars = array();

    public static function setTemplatesDirectory($directory)
    {
        self::$templatesDirectory = $directory;
    }

    public static function setGlobalVars(array $vars)
    {
        self::$globalVars = $vars;
    }

    private $layout;
    private $filename;
    private $vars = array();

    public function __construct($filename = null)
    {
        if ($filename !== null)
        {
            $this->filename = $filename;
        }
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }

    public function render($filename = null, array $vars = array())
    {
        $vars = array_merge(self::$globalVars, $this->vars, $vars);
        foreach ($vars as $key => $value)
        {
            $$key = $value;
        }

        ob_start();
        include (self::$templatesDirectory ?: '.') . DS . ($filename ?: $this->filename);
        $output = ob_get_contents();
        ob_end_clean();

        if ($this->layout && $filename !== $this->layout)
        {
            $output = $this->render($this->layout, array_merge($vars, array(
                'content_for_layout' => $output
            )));
        }
        return $output;
    }

    public function url($url)
    {
        return BASE_URL . '/' . ltrim($url, '/');
    }

}
