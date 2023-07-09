<?php

namespace App\Core;

class Request
{
    public static function uri()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = trim($uri, '/');
        $segments = explode('/', $path);

        if (count($segments) >= 3) {
            $result = [$segments[0] . '/' . $segments[1], $segments[2]];
        } elseif (count($segments) == 1) {
            $result = $segments;
        } else {
            $result = [$segments[0] . '/' . $segments[1], ''];
        }

        return $result;
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
