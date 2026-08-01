<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['word', 'entity', 'entity_id', 'action', 'user_id'])]
class History extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
