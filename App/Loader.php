<?php

namespace App;

final class Loader
{
    public function view($template, $data = array())
    {
        $file = DIR_TEMPLATE . $template;

        if (file_exists($file)) {
            extract($data);

            ob_start();

            require($file);

            $output = ob_get_contents();

            ob_end_clean();

            return $output;
        } else {
            echo 'Error: Could not load template ' . $file . '!';
            exit();
        }
    }
}