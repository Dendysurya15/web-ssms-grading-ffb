<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListMill extends Model
{

    protected $table = 'list_mill';
    use HasFactory;

    // public function logSamplings()
    // {
    //     return $this->hasMany(LogSampling::class);
    // }
    // public function reg()
    // {
    //     return $this->belongsTo(Regional::class, 'reg_id');
    // }
}
