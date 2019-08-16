<?php


namespace Lumille\Http;


use Lumille\Singleton;

class Request extends Singleton
{

    public static function isSecure (): bool
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off';
    }

    public static function getDomain (): string
    {
        $port = $_SERVER['SERVER_PORT'];
        $domain = sprintf(
            "%s://%s",
            static::isSecure() ? 'https' : 'http',
            $_SERVER['SERVER_NAME']
        );

        if ($port) {
            $domain .= ':' . $port;
        }
        return $domain;
    }

    public static function getRequestUri (): string
    {
        return static::getDomain() . $_SERVER['REQUEST_URI'];
    }

    public static function documentRoot () :string
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }
}