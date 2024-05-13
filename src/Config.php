<?php

namespace Hogus\ApiSignature;

use Illuminate\Config\Repository;

class Config
{
    protected $config;
    public function __construct(array $config)
    {
        $this->config = new Repository($config);
    }

    public function getSignKey()
    {
        return $this->config->get('sign_key');
    }

    public function getSecret()
    {
        return $this->config->get('secret');
    }

    public function getEnabled()
    {
        return $this->config->get('enabled', false);
    }

    public function getTimestamp()
    {
        return $this->config->get('timestamp_key', 'timestamp');
    }

    public function getTimeout()
    {
        return $this->config->get('timeout', 0);
    }

    public function get($key, $default = null)
    {
        return $this->config->get($key, $default);
    }

    public function __call($name, $arguments)
    {
        return $this->config->{$name}(...$arguments);
    }
}