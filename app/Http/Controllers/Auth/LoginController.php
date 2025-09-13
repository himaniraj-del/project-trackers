<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\UserLog;

class LoginController extends Controller
{
    protected function authenticated(Request $request, $user)
{
    UserLog::create([
        'user_id' => $user->id,
        'action' => 'login',
        'description' => 'User logged in',
        'ip_address' => $request->ip(),
    ]);
}
}
