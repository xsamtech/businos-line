<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['file_name', 'file_description', 'file_url', 'file_type', 'mime_type', 'file_size', 'user_id'])]
class File extends Model
{
    use SoftDeletes;
}
