<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\Attributes\Translatable;
use Spatie\Translatable\HasTranslations;

#[Fillable(['role_name', 'role_description', 'slug'])]
#[Translatable('role_name', 'role_description')]
class Role extends Model
{
    use HasTranslations, HasUuid, SoftDeletes;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['is_default', 'assigned_at'])->withTimestamps();
    }
}
