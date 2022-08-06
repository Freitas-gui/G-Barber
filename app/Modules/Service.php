<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schedule_id', 'name', 'value', 'image', 'duration', 'created_at', 'updated_at'
    ];
}
