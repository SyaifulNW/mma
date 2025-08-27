<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override redirectTo untuk arahkan sesuai role.
     */
    protected function redirectTo()
    {
        $role = auth()->user()->role;

        switch ($role) {
            case 'admin':
                return '/admin/dashboard';
            case 'coach':
                return '/coach/dashboard';
            case 'peserta':
                return '/peserta/dashboard';
            default:
                return RouteServiceProvider::HOME;
        }
    }
}
