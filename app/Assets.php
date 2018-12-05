<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Uuids;


class Assets extends Model
{
    use Uuids;

    protected $table = 'assets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'calendar_id','name',
    ];

    public $incrementing = false;

}
