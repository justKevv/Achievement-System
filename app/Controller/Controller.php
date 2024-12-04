<?php

namespace App\Controller;

class Controller
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    protected function render($view, $data = [])
    {
        extract($data);
        include $view;
    }
}
