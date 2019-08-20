<?php


namespace Lumille\Http;


use Lumille\Singleton;
use Symfony\Component\HttpFoundation\Request as FoundationRequest;

class Request
{

    private $request;

    public function __construct ()
    {
        $this->request = FoundationRequest::createFromGlobals();
    }

    public function __get ($prop)
    {
        return $this->request->$prop;
    }

    public function __set ($prop, $value)
    {
        $this->request->$prop = $value;
        return $this->request;
    }

    public function __call ($name, array $args = [])
    {
        return \call_user_func_array([$this->request, $name], $args);
    }

    private function getProperty ($property, $name = null, $default = null)
    {
        if ($name) {
            return $this->$property->get($name, $default);
        }
        return $this->request->$property;
    }

    public function getQuery ($name = null, $default = null)
    {
        return $this->getProperty('query', $name, $default);
    }

    public function getRequest ($name = null, $default = null)
    {
        return $this->getProperty('request', $name, $default);
    }

    public function getCookies ($name = null, $default = null)
    {
        return $this->getProperty('cookies', $name, $default);
    }

    public function getAttributes ($name = null, $default = null)
    {
        return $this->getProperty('attributes', $name, $default);
    }

    public function getFiles ($name = null, $default = null)
    {
        return $this->getProperty('files', $name, $default);
    }

    public function getServer ($name = null, $default = null)
    {
        return $this->getProperty('server', $name, $default);
    }

    public function getHeaders ($name = null, $default = null)
    {
        return $this->getProperty('headers', $name, $default);
    }
}