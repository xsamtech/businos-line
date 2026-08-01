<?php

namespace App\Services;

use App\Models\PasswordResetToken;
use App\Models\User;

class PasswordResetCodeService
{
    public function generate(User $user): string
    {
        $code = (string) random_int(100000, 999999);
        PasswordResetToken::query()->updateOrCreate(
            ['email' => $user->email],
            ['phone' => $user->phone, 'token' => $code, 'former_password' => $user->password],
        );

        return $code;
    }
}
