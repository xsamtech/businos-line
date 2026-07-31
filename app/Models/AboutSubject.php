<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\Attributes\Translatable;
use Spatie\Translatable\HasTranslations;

#[Fillable(['subject', 'description', 'icon', 'is_available'])]
#[Translatable('subject', 'description')]
class AboutSubject extends Model
{
    use HasTranslations, HasUuid, SoftDeletes;

    protected $attributes = ['is_available' => true];

    protected function casts(): array
    {
        return ['is_available' => 'boolean'];
    }

    public function titles(): HasMany
    {
        return $this->hasMany(AboutTitle::class)->latest();
    }
}
