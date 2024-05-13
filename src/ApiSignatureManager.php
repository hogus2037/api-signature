<?php

namespace  Hogus\ApiSignature;

use Closure;
use InvalidArgumentException;
class ApiSignatureManager
{
    /**
     * Application
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    protected $guards = [];

    protected $customCreators = [];

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function guard(string $guard = null)
    {
        $name = $guard ?: $this->getDefaultGuard();

        return $this->guards[$name] ?? $this->guards[$name] = $this->resolve($name);
    }

    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("API Signature Guard [{$name}] is not defined.");
        }

        if (isset($this->customCreators[$config['driver']])) {
            return $this->callCustomCreator($name, $config);
        }

        $driverMethod = "create".ucfirst($config['driver'])."Driver";
        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($name, $config);
        }

        throw new InvalidArgumentException("API Signature driver [{$config['driver']}] for guard [{$name}] is not defined.");
    }

    protected function createMD5Driver($name, array $config)
    {
        return new MD5Guard($this->app['request'], $config);
    }

    protected function createHashDriver($name, array $config)
    {
        return new HashGuard($this->app['request'], $config);
    }

    protected function callCustomCreator($name, array $config)
    {
        return $this->customCreators[$config['driver']]($this->app, $name, $config);
    }

    public function extend($driver, Closure $callback)
    {
        $this->customCreators[$driver] = $callback;

        return $this;
    }

    protected function getDefaultGuard()
    {
        return $this->app['config']['sign.default'];
    }

    protected function getConfig($name)
    {
        return $this->app['config']["sign.guards.{$name}"];
    }

    public function __call($name, $arguments)
    {
        return $this->guard()->{$name}(...$arguments);
    }
}