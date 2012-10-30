<?php

namespace Core;

class Response
{

    const DEFAULT_CHARSET = 'utf-8';

    private $output = '';
    private $contentType = 'text/plain';
    private $charset;

    public function __construct()
    {
        $this->setCharset(self::DEFAULT_CHARSET);
    }

    public function render($filename, $vars = array())
    {
        $tpl = new Template();
        $this->setOutput($tpl->render($filename, $vars));
        $this->setContentType('text/html');
        return $this;
    }

    public function json($data)
    {
        $this->setOutput(json_encode($data));
        $this->setContentType('text/plain');
        return $this;
    }

    public function output()
    {
        $this->header('Content-type', $contentType . '; charset=' . $charset);
        echo $this->getOutput();
    }

    public function setOutput($output)
    {
        $this->output = $output;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    public function header($name, $data = '')
    {
        header($name . ($data ? ': ' . $data : ''));
    }

}
