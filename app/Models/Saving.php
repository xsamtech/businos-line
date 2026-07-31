<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['is_saving_sent', 'amount', 'currency', 'month', 'year', 'user_id'])]
class Saving extends Model
{
    use HasUuid, SoftDeletes;

    protected $attributes = ['is_saving_sent' => false, 'amount' => 0, 'currency' => 'EUR'];

    protected function casts(): array
    {
        return ['is_saving_sent' => 'boolean', 'amount' => 'decimal:2'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
