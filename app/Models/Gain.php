<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['amount', 'currency', 'is_general_interest_paid', 'is_gain_paid', 'month', 'year', 'user_id'])]
class Gain extends Model
{
    use HasUuid, SoftDeletes;

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'is_general_interest_paid' => 'boolean', 'is_gain_paid' => 'boolean'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
