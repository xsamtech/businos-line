<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PasswordResetCodeNotification;
use App\Services\PasswordResetCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function __construct(private PasswordResetCodeService $resetCodes) {}

    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['email' => ['required', 'email', 'exists:users,email']]);
        $user = User::where('email', $data['email'])->firstOrFail();
        $user->notify(new PasswordResetCodeNotification($this->resetCodes->generate($user)));

        return back()->with('status', __('messages.reset_code_sent'));
    }
}
