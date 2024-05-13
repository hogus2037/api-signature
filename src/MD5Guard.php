<?php

namespace Hogus\ApiSignature;

class MD5Guard extends AbstractGuard
{
    public function signature(): string
    {
        return strtoupper(md5($this->generate()));
    }
}