<?php

namespace App\Http\Middleware;

use App\Services\AuthenticationService;
use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    public function __construct(private AuthenticationService $service)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        if (!$this->service->isAuthenticated()) {
            return redirect()->to('/account/login');
        }
        return $next($request);
    }
}
