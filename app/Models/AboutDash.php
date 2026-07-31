<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\Attributes\Translatable;
use Spatie\Translatable\HasTranslations;

#[Fillable(['dash_content', 'belongs_to', 'about_content_id'])]
#[Translatable('dash_content')]
class AboutDash extends Model
{
    use HasTranslations, SoftDeletes;

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'belongs_to')->with('children');
    }
}
