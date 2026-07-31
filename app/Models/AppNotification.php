<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['type', 'is_read', 'from_user_id', 'to_user_id', 'payment_id', 'saving_id', 'gain_id'])]
class AppNotification extends Model
{
    protected $table = 'notifications';

    protected function casts(): array
    {
        return ['is_read' => 'boolean'];
    }
}
