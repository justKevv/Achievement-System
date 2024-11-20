<?php

class ErrorHandler
{
    public static function handle404()
    {
        http_response_code(404);
        include '../../resources/views/components/404.html';
    }
}
