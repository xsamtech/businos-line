<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['subtitle', 'content', 'about_title_id'])]
class AboutContent extends Model
{
    use HasUuid, SoftDeletes;

    public function title(): BelongsTo
    {
        return $this->belongsTo(AboutTitle::class, 'about_title_id');
    }

    public function dashes(): HasMany
    {
        return $this->hasMany(AboutDash::class)->whereNull('belongs_to')->with('children');
    }
}
