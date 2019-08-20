<?php


namespace Lumille\Http;


use Symfony\Component\HttpFoundation\Response as FondationResponse;

class Response
{
    private $response;

    public function __construct ()
    {
        $this->response = new FondationResponse();
    }

    public function __get ($prop)
    {
        return $this->response->$prop;
    }

    public function __set ($prop, $value)
    {
        $this->response->$prop = $value;
        return $this->response;
    }

    public function __call ($name, array $args = [])
    {
        return  \call_user_func_array([$this->response, $name], $args);
    }

    /**
     * @param string|array $key
     * @param string|null $value
     * @return FondationResponse
     */
    public function setHeaders ($key, $value = null)
    {
        if ($value) {
            $key = [$key => $value];
        }

        foreach ($key as $k => $v) {
            $this->response->headers->set($k, $v);
        }

        return $this->response;
    }
}