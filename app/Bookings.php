<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'title', 'start_time', 'end_time',
    ];
}
