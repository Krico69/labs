<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'entity', 'entity_id', 'file_path', 'original_name'
    ];
}