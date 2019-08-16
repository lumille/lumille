<?php


namespace Lumille\Router;


class Route
{
    protected $groupedName;
    private function push ($method, $url, $callable, $name = null)
    {
        if ($this->groupedName) {
            $url = preg_replace('#\/$#', '', $this->groupedName . $url);
        }

        RouteCollection::push($method, $url, $callable, $name);
    }

    public function setGroup($name)
    {
        $this->groupedName = $name;
    }

    public function get ($url, $callable, $name = null)
    {
        $this->push('get', $url, $callable, $name);
    }

    public function post ($url, $callable, $name = null)
    {
        $this->push('post', $url, $callable, $name);
    }

    public function put ($url, $callable, $name = null)
    {
        $this->push('put', $url, $callable, $name);
    }

    public function patch ($url, $callable, $name = null)
    {
        $this->push('patch', $url, $callable, $name);
    }

    public function delete ($url, $callable, $name = null)
    {
        $this->push('delete', $url, $callable, $name);
    }

    public function all ($url, $callable, $name)
    {
        $this->get($url, $callable, $name);
        $this->post($url, $callable, $name);
        $this->put($url, $callable, $name);
        $this->patch($url, $callable, $name);
        $this->delete($url, $callable, $name);
    }
}