<?php


namespace Lumille\Providers;


class ServiceProvider
{
    protected $app;

    public function __construct ($app)
    {

        $this->app = $app;
    }

    public function register()
    {}

    public function boot()
    {}
}