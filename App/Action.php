<?php

namespace App;

final class Action 
{
    private $file;
    private $class;
    private $method;
    private $args = array();

    public function __construct($route, $args = array())
    {
        $path = '';

        // Break apart the route
        $parts = explode('/', str_replace('_', '/', (string)$route));

        foreach ($parts as $part) {
            $path .= $part;

            if (is_dir(__DIR__. '/Controllers/' . $path)) {
                $path .= '/';

                array_shift($parts);

                continue;
            }

            $file = __DIR__ . '/Controllers/' . $path . '.php';

            if (is_file($file)) {
                $this->file = $file;

                $this->class = $part;

                array_shift($parts);

                break;
            }
        }

        if ($args) {
            $this->args = $args;
        }

        $method = array_shift($parts);

        if ($method) {
            $this->method = $method;
        } else {
            $this->method = 'index';
        }
    }

    public function execute($registry)
    {
        if (is_file($this->file)) {
            include_once($this->file);

            $class = '\App\Controllers\\' . $this->class;

            $controller = new $class($registry);

            if (is_callable(array($controller, $this->method))) {
                return call_user_func(array($controller, $this->method), $this->args);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}