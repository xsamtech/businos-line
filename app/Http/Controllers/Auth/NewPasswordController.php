<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['token' => ['required', 'digits:6'], 'email' => ['required', 'email'], 'password' => ['required', 'confirmed', Rules\Password::defaults()]]);
        $reset = PasswordResetToken::where('email', $data['email'])->where('token', $data['token'])->first();
        if (! $reset || $reset->created_at?->lt(now()->subMinutes(15))) {
            throw ValidationException::withMessages(['token' => __('messages.invalid_reset_code')]);
        }
        $user = User::where('email', $data['email'])->firstOrFail();
        $user->forceFill(['password' => Hash::make($data['password']), 'remember_token' => Str::random(60)])->save();
        $reset->delete();
        event(new PasswordReset($user));

        return redirect()->route('login')->with('status', __('messages.password_reset_success'));
    }
}
