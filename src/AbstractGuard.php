<?php

namespace Hogus\ApiSignature;

use Illuminate\Http\Request;

abstract class AbstractGuard implements SignatureInterface
{
    protected $request;

    protected $config;
    public function __construct(Request $request, array $config)
    {
        $this->request = $request;
        $this->config = new Config($config);
    }

    abstract public function signature();

    protected function getSignKey()
    {
        return $this->config->getSignKey();
    }

    protected function getSignForRequest()
    {
        $key = $this->getSignKey();

        $sign = $this->request->query($key);

        if (empty($sign)) {
            $sign = $this->request->input($key);
        }

        if (empty($sign)) {
            $sign = $this->request->header($key);
        }

        return $sign;
    }

    protected function getTimestampForRequest()
    {
        $key = $this->config->getTimestamp();

        $timestamp = $this->request->query($key);

        if (empty($timestamp)) {
            $timestamp = $this->request->input($key);
        }

        if (empty($timestamp)) {
            $timestamp = $this->request->header($key);
        }

        return $timestamp;
    }

    public function check(): bool
    {
        if ($this->config->getEnabled() === false) {
            return true;
        }

        if ($this->config->getTimeout() > 0) {
            $timestamp = $this->getTimestampForRequest() ?: 0;
            if (abs(time() - $timestamp) > $this->config->getTimeout()) {
                throw new ApiSignatureException("The request signature has expired.");
            }
        }

        if ($this->getSignForRequest() != $this->signature()) {
            throw new ApiSignatureException("The request signature could not be verified.");
        }

        return true;
    }

    public function generate()
    {
        $params = $this->request->except($this->getSignKey());
        ksort($params);

        $query = '';
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
            }
            $query .= "{$key}={$value}&";
        }

        $query .= "key={$this->config->getSecret()}";

        return $query;
    }
}