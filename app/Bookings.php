<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $table = 'booking';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'title', 'date', 'start_time', 'end_time'
    ];
}
