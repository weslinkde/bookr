<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id';
    protected $appends = array('creator_nicename');

    protected $fillable = [
        'user_id','title', 'description', 'type', 'start_time', 'end_time',
    ];

    public function getCreatorNicenameAttribute(){
        return User::find($this->user_id)->name;
    }
}
