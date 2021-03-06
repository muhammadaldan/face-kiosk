<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    public function abcent()
    {
        return $this->hasMany('App\Models\Abcent');
    }
}
