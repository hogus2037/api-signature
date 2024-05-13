<?php

namespace Hogus\ApiSignature;

class HashGuard extends AbstractGuard
{
    public function signature()
    {
        $sign = hash_hmac($this->getAlgo(), $this->generate(), $this->getSignKey());
        return strtoupper($sign);
    }

    public function getAlgo()
    {
        return $this->config->get('algo', 'sha256');
    }
}