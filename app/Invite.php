<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Uuids;

class Invite extends Model
{
    use Uuids;
    protected $fillable = [
        'team_id', 'token','created_at'
    ];

    public $incrementing = false;
}
