<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Uuids;

class Calendars extends Model
{
    use Uuids;

    protected $table = 'calendars';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'team_id',
        'name',
    ];

    public $incrementing = false;

}
