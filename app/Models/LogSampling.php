<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSampling extends Model
{

    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'log_sampling';


    public function listMill()
    {
        return $this->belongsTo(ListMill::class, 'mill_id');
    }
}
