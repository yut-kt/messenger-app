<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $timestamps = false;

    protected $table = 'rooms';
    protected $fillable = [
        'room_id', 'room_name', 'user_id', 'read'
    ];
}
