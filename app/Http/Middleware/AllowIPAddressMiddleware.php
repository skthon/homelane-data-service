<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            ! $request->has('bypass_ip')
            && (
                ! is_array($whitelistedIpAddresses)
                || ! in_array($request->ip(), $whitelistedIpAddresses)
            )
        ) {
            // Log internal message to take measures
            Log::info("[error] [data-api-access] Invalid ip address detected " . $request->ip());
            return response()->json(['message' => "404 not found"]);
        }

        return $next($request);
    }
}
