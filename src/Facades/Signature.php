<?php

namespace Hogus\ApiSignature\Facades;

use Illuminate\Support\Facades\Facade;

class Signature extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'signature';
    }
}