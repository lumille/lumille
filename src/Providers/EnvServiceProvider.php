<?php


namespace Lumille\Providers;

class EnvServiceProvider extends ServiceProvider
{
    public function register ()
    {
        $dotenv = \Dotenv\Dotenv::create($this->app->getRootDir());
        $dotenv->load();
    }
}