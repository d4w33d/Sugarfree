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

    public static function setGlobalVars($vars)
    {
        self::$globalVars = $vars;
    }

    private $filename;
    private $vars = array();

    public function __construct($filename = null)
    {
        if ($filename !== null)
        {
            $this->filename = $filename;
        }
    }

    public function setVars($vars)
    {
        $this->vars = $vars;
    }

    public function render($filename = null, $vars = array())
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
        return $output;
    }

}
