<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowIPAddressMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $whitelistedIpAddresses = explode(',', config('data_service.ip_addresses'));

        // return error if whitelisted ip address are not specified or on detecting non-whitelisted ip address
        if (
            // TODO: heroku doesn't support static ips, Need to implement a workaround
            ! $request->has('bypass_api')
            && (
                ! is_array($whitelistedIpAddresses)
                || ! in_array($request->ip(), $whitelistedIpAddresses)
            )
        ) {
            return response()->json(['message' => "404 not found"]);
        }

        return $next($request);
    }
}
