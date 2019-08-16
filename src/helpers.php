<?php

use Lumille\Router\Router;
use Lumille\View\View;

if (!function_exists('partial')) {
    function partial($name, array $params = [])
    {
        extract($params);
        require_once(PARTIALS . $name . '.php');
    }
}

if (!function_exists('h')) {
    function h($value)
    {
        return strip_tags($value);
    }
}


if (!function_exists('image')) {
    function image($name)
    {
        return '/images/' . $name;
    }
}

if (!function_exists('pageActive')) {
    function pageActive($file)
    {
        $url = $_SERVER['REQUEST_URI'];

        if (preg_match('#'.$file.'#', $url)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('blade_share')) {
    function blade_share($name, $value = null) {
        View::share($name, $value);
    }
}

if (!function_exists('render')) {
    function render($view, array $params = []) {
        echo View::render($view, $params);
    }
}


if (!function_exists('url_back')) {
    function url_back ()
    {
        $currentUrl = $_SERVER['REQUEST_URI'];
        if (isset($_SERVER['HTTP_REFERER']) && !preg_match("#" . $currentUrl . "#", $_SERVER['HTTP_REFERER']) ) {
            return $_SERVER['HTTP_REFERER'];
        }

        return '/';
    }
}

if (!function_exists('back')) {
    function back()
    {
        $url = url_back();
        header('Location: ' . $url);
        exit;
    }
}

if (!function_exists('current_url')) {
    function current_url()
    {
        return $_SERVER['REQUEST_URI'];
    }
}

if (!function_exists('url_query')) {
    function url_query()
    {
        $stringQuery = $_SERVER['QUERY_STRING'];
        parse_str($stringQuery, $query_array);
        return $query_array;
    }
}

if (!function_exists('url_query_exists')) {
    function url_query_exists($name)
    {
        $query = url_query();
        return array_key_exists($name, $query);
    }
}

if (!function_exists('current_url_equal')) {
    function current_url_equal($name)
    {
        var_dump($_SERVER['QUERY_STRING']);
        return current_url() === $name;
    }
}

if (!function_exists('dump')) {
    function dump($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}

if (!function_exists('dd')) {
    function dd($data)
    {
        dump($data);
        die;
    }
}

if (!function_exists('route')) {
    function route($name)
    {
        return Router::route($name);
    }
}

