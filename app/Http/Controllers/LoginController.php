<?php

namespace App\Http\Controllers;

use App\Services\AuthenticationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function __construct(private AuthenticationService $auth_service)
    {
    }

    public function index(Request $request)
    {
        return Inertia::render("Login");
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => [
                'required',
                'string'
            ],
            'password' => [
                'required',
                'string'
            ]
        ]);

        [
            'username' => $username,
            'password' => $password
        ] = $request->all();
        if ($this->auth_service->authenticate($username, $password)) {
            return redirect()->to("/", 304);
        } else {
            return redirect()->to('/account/login')->withErrors([
                'error_message' => 'Invalid username or password.'
            ]);
        };
    }
}
