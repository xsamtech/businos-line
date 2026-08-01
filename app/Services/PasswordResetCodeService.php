<?php

namespace App\Services;

use App\Models\PasswordResetToken;
use App\Models\User;

class PasswordResetCodeService
{
    public function generate(User $user): string
    {
        $code = (string) random_int(100000, 999999);
        PasswordResetToken::query()->updateOrCreate(['email' => $user->email], ['token' => $code, 'created_at' => now()]);

        return $code;
    }
}
