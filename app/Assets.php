<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    protected $table = 'assets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'href',
    ];
}
