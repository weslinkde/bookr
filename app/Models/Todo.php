<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    public $table = "todos";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
// Todo table data
    ];

    public static $rules = [
        // create rules
    ];

    // Todo 
}
