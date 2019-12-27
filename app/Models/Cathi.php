<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cathi extends Model
{
    protected $table = 'cathis';
    protected $fillable = [
        'user_id',
        'name',
        'quantityPC',
        'dayExam',
        'room',
        'startTime',
        'endTime',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function monthis() {
        return $this->belongsToMany('App\Models\Monthi', 'cathi_monthi');
    }
}
