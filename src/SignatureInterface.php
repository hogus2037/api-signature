<?php

namespace Hogus\ApiSignature;

interface SignatureInterface
{
    /**
     * @return bool
     *
     * @throws \Hogus\ApiSignature\ApiSignatureException
     */
    public function check();

    /**
     * @return string
     */
    public function signature();

    /**
     * @return string
     */
    public function generate();
}