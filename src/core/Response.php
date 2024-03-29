<?php

namespace Core;

use Closure;

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

    public function render($filename, array $vars = array(), $layout = null)
    {
        $tpl = new Template();
        $tpl->setLayout($layout);
        $this->setOutput($tpl->render($filename, $vars));
        $this->setContentType('text/html');
        return $this;
    }

    public function json(array $data)
    {
        $this->setOutput(json_encode($data));
        $this->setContentType('text/plain');
        return $this;
    }

    public function redirect($url)
    {
        $self = $this;
        $this->setOutput(function() use ($self, $url)
        {
            if (strpos($url, '://') === false)
            {
                $url = BASE_URL
                    . (BASE_URL !== '/' ? '/' : '')
                    . ltrim($url, '/');
            }
            $self->header('Location', $url);
        });
        return $this;
    }

    public function output()
    {
        $output = $this->getOutput();
        if ($output instanceof Closure)
        {
            $output();
            return;
        }
        $this->header('Content-type', $this->contentType . '; charset=' . $this->charset);
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
