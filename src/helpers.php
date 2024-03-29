<?php

use Lumille\Foundation\Session;

if (!function_exists('app')) {
    function app ($name = null)
    {
        global $app;
        if ($name) {
            return $app->getDic($name);
        }

        return $app;
    }
}

if (!function_exists('config')) {
    function config ($name, $value = null)
    {
        if ($value) {
            \Config::insert($name, $value);
        }

        return \Config::get($name);
    }
}


if (!function_exists('h')) {
    function h ($value)
    {
        return strip_tags($value);
    }
}


if (!function_exists('image')) {
    function image ($name)
    {
        return '/images/' . $name;
    }
}

if (!function_exists('pageActive')) {
    function pageActive ($file)
    {
        $url = $_SERVER['REQUEST_URI'];

        if (preg_match('#' . $file . '#', $url)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('blade_share')) {
    function blade_share ($name, $value = null)
    {
        if (!is_array($name)) {
            $name = [$name => $value];
        }

        foreach ($name as $k => $v) {
            \View::share($k, $v);
        }
    }
}

if (!function_exists('render')) {
    function render ($view, array $params = [])
    {
        $render = \View::make($view, $params);
        return \Response::setHeaders('Content-type', 'text/html')
            ->setContent($render);
    }
}


if (!function_exists('url_back')) {
    function url_back ()
    {
        $currentUrl = $_SERVER['REQUEST_URI'];
        if (isset($_SERVER['HTTP_REFERER']) && !preg_match("#" . $currentUrl . "#", $_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        }

        return '/';
    }
}

if (!function_exists('back')) {
    function back ()
    {
        $url = url_back();
        header('Location: ' . $url);
        exit;
    }
}

if (!function_exists('current_url')) {
    function current_url ()
    {
        return $_SERVER['REQUEST_URI'];
    }
}

if (!function_exists('url_query')) {
    function url_query ()
    {
        $stringQuery = $_SERVER['QUERY_STRING'];
        parse_str($stringQuery, $query_array);
        return $query_array;
    }
}

if (!function_exists('url_query_exists')) {
    function url_query_exists ($name)
    {
        $query = url_query();
        return array_key_exists($name, $query);
    }
}

if (!function_exists('current_url_equal')) {
    function current_url_equal ($name)
    {
        var_dump($_SERVER['QUERY_STRING']);
        return current_url() === $name;
    }
}

if (!function_exists('session')) {
    function session ($key, $default = null)
    {
        return Session::get($key, $default);
    }
}

if (!function_exists('session_set')) {
    function session_set ($key, $value = null)
    {
        Session::set($key, $value);
    }
}

if (!function_exists('route')) {
    function route ($name, array $params = [])
    {
        global $app;
        return $app->getRouter()->getUrl($name, $params);
    }
}

if (!function_exists('redirect')) {
    function redirect ($url, $params = [])
    {
        if (!preg_match('#^https?:\/\/#', $url)) {
            $url = route($url, $params) ?? $url;
        }

        header('Location: ' . $url);
        exit;
    }
}





