<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CathiMonthi extends Model
{
	
	protected $table = 'cathi_monthi';

    protected $fillable = [
        'cathi_id',
        'monthi_id',
    ];
}
