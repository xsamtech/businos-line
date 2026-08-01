<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['complaint', 'is_unlocked', 'user_id', 'about_title_id'])]
class BlockedUser extends Model
{
    use HasUuid, SoftDeletes;

    protected function casts(): array
    {
        return ['is_unlocked' => 'boolean'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function aboutTitle(): BelongsTo
    {
        return $this->belongsTo(AboutTitle::class);
    }
}
