<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $table = 'my_bookings';
    public $timestamps = false;
    protected $primaryKey = 'my_id';
}
