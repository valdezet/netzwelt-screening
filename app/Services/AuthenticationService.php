<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthenticationService
{

    public function __construct(private Request $request)
    {
    }

    public function authenticate(string $username, string $password): bool
    {
        $response = Http::post('https://netzwelt-devtest.azurewebsites.net/Account/SignIn', [
            'username' => $username,
            'password' => $password
        ]);
        if ($response->successful()) {
            $data = $response->json();

            $this->saveToSession($data);
            return true;
        } else if ($response->status() === 404) {
            return false;
        } else $response->throw();
    }

    public function isAuthenticated(): bool
    {
        return $this->request->exists('userdata');
    }

    private function saveToSession($user_data)
    {
        session(['userdata' => $user_data]);
    }
}
