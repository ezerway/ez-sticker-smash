<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['id', 'firebase_id', 'expo_push_token', 'locale', 'created_at', 'updated_at'];

    protected $casts = ['created_at' => 'date', 'updated_at' => 'date'];
}
