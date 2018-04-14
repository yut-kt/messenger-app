<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friends';
    protected $fillable = [
        'user_id', 'to_user_id'
    ];
}
