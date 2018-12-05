<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Uuids;

class Bookings extends Model
{
    use Uuids;
    protected $table = 'booking';
    protected $primaryKey = 'id';
    protected $appends = array('creator_nicename');

    protected $fillable = [
        'user_id','title', 'description', 'type', 'recurring', 'start', 'end', 'start_time', 'end_time',
    ];

    public $incrementing = false;

    public function getCreatorNicenameAttribute(){
        return User::find($this->user_id)->name;
    }
}
