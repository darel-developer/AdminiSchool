<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockMobileDevices
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('mobile-blocked')) {
            return $next($request);
        }

        if ($this->isMobileDevice($request)) {
            return redirect('/mobile-blocked');
        }

        return $next($request);
    }

    private function isMobileDevice(Request $request)
    {
        $userAgent = $request->header('User-Agent');
        return preg_match('/Mobile|Android|iP(hone|od|ad)|Opera Mini|IEMobile/', $userAgent);
    }
}
