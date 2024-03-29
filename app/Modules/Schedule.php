<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'init', 'end', 'status', 'created_at', 'updated_at'
    ];
}
