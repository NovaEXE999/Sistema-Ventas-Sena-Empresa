<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckUserStatus extends Component
{
    public function check()
    {
        if (! Auth::check()) {
            return;
        }

        if (! Auth::user()->status) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login')->with('error', __('Tu cuenta fue deshabilitada.'));
        }
    }

    public function render()
    {
        return view('livewire.check-user-status');
    }
}
