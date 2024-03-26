<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sticker extends Model
{
    protected $fillable = ['id', 'sticker_id', 'description', 'colors', 'color', 'shape', 'family_id', 'family_name', 'team_name', 'added', 'pack_id', 'pack_name', 'pack_items', 'tags', 'equivalents', 'images', 'created_at', 'updated_at'];

    protected $casts = ['images' => 'array', 'created_at' => 'date', 'updated_at' => 'date'];
}
