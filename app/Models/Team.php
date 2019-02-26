<?php

namespace App\Models;

use App\Models\User;
use App\Uuids;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use Uuids;

    public $table = "teams";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        'user_id',
        'name',
        'description'
    ];

    public $incrementing = false;

    public static $rules = [
        'name' => 'required|unique:teams'
    ];

    public function members()
    {
        return $this->belongsToMany(User::class);
    }
}
