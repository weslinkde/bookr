<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendars extends Model
{
    protected $table = 'calendars';
    protected $primaryKey = 'id';
    protected $fillable = [
        'team_id','name',
    ];
}
