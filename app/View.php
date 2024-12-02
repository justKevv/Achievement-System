<?php

namespace App;

class View
{
    public static function render($view, $data = [])
    {
        extract($data);
        include $view;
    }
}
