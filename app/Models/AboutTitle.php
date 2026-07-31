<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['title', 'icon', 'about_subject_id'])]
class AboutTitle extends Model
{
    use HasUuid, SoftDeletes;

    public function subject(): BelongsTo
    {
        return $this->belongsTo(AboutSubject::class, 'about_subject_id');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(AboutContent::class)->oldest();
    }
}
