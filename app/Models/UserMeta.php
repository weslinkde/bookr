<?php

namespace App\Models;

use App\Models\User;
use App\Uuids;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use Uuids;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'phone',
        'marketing',
        'terms_and_cond',
        'is_active',
        'activation_token',
    ];

    public $incrementing = false;

    /**
     * User
     *
     * @return Relationship
     */
    public function user()
    {
        return User::where('id', $this->user_id)->first();
    }

}
