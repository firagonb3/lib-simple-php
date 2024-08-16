<?php

namespace lib;

class Render
{
    private static $baseHTML = null;

    public static function view($route, $data = [])
    {
        extract($data);
        $route = str_replace('.', '/', $route);

        if (file_exists("{$route}.php")) {
            ob_start();
            include "{$route}.php";

            if (self::$baseHTML === null) {
                return ob_get_clean();
            }

            return str_replace('</body>', ob_get_clean() . '</body>', self::$baseHTML);

        } else {
            die('El archivo no existe');
        }
    }

    public static function component($route, $data = [])
    {
        extract($data);
        $route = str_replace('.', '/', $route);

        if (file_exists("{$route}.php")) {
            ob_start();
            include "{$route}.php";
            return ob_get_clean();
        } else {
            die('El archivo no existe');
        }
    }

    public static function setBaseHTML($route)
    {
        $route = str_replace('.', '/', $route);

        if (file_exists("{$route}.php")) {
            ob_start();
            include "{$route}.php";
            self::$baseHTML = ob_get_clean();
        } else {
            die('El archivo no existe');
        }
    }
}
