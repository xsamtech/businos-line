<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['email', 'token', 'created_at'])]
class PasswordResetToken extends Model
{
    protected $primaryKey = 'email';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }
}
