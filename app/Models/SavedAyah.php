<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedAyah extends Model
{
    protected $fillable = [
        'user_id', 'surah', 'ayah', 'ayah_image', 'text', 'sajda', 'audio'
    ];
}

