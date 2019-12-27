<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monthi extends Model
{
    protected $table = 'monthis';
    protected $fillable = [
        'user_id',
        'name',
        'subjectid',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function cathis() {
        return $this->belongsToMany('App\Models\Cathi', 'cathi_monthi');
    }
}
