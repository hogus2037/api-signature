<?php

namespace Hogus\ApiSignature\Middleware;

use Closure;
use Hogus\ApiSignature\Facades\Signature;
use Hogus\ApiSignature\ApiSignatureException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        $this->check($guards);

        return $next($request);
    }

    protected function check($guards)
    {
        foreach ($guards as $guard) {
            if (Signature::guard($guard)->check()) {
                return true;
            }
        }

        throw new ApiSignatureException("The request signature could not be verified.");
    }
}
