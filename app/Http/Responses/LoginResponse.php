<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request instanceof Request ? $request->user() : null;

        $fallback = route('dashboard');

        if ($user?->isAdmin()) {
            $fallback = route('reports.index');
        } elseif ($user?->isVendor()) {
            $fallback = route('sales.index');
        }

        return redirect()->intended($fallback);
    }
}

