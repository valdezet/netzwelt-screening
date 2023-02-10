<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Services\AuthenticationService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function __construct(private AuthenticationService $service)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->service->isAuthenticated()) {
            return redirect()->to('/');
        }

        return $next($request);
    }
}
