<?php

namespace Fvy\Group404;

class Template
{
    private $scriptPath = TEMPLATE_PATH;
    public $properties;
    public $title;

    public function __construct()
    {
        $this->properties = [];
    }

    /**
     * @param $filename
     * @return false|string
     * @throws \Exception
     */
    public function render($filename)
    {
        ob_start();
        $tmpl = $this->scriptPath . "/" . $filename . ".php";
        if (file_exists($tmpl)) {
            include_once($tmpl);
        } else {
            throw new \Exception("Can't find template ``" . $tmpl . "``");
        }
        return ob_get_clean();
    }

    public function __set($k, $v)
    {
        $this->properties[$k] = $v;
    }

    public function __get($k)
    {
        return $this->properties[$k];
    }
}