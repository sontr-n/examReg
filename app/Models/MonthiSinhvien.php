<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthiSinhvien extends Model
{
    protected $table = 'sinhvien_monthi';
    protected $fillable = [
        'studentId',
        'monthiId',
        'eligible',
    ];

}

?>