<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendars extends Model
{
    protected $table = 'calendars';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'team_id',
        'name',
    ];
}
